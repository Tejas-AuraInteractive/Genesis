<?php



if ($slider_enabled) {
    /**
     * Adds Slider_Widget widget.
     */
    class Slider_Widget extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {
            parent::__construct(
                'dizeno_slider_widget', // Base ID
                __( 'Dizeno - Slider', 'text_domain' ), // Name
                array( 'description' => __( 'A slider for your site.', 'text_domain' ), ) // Args
            );
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget( $args, $instance ) {
            
            global $origin_theme;
                $slider_width       = '';
                $slider_width_value = $origin_theme['opt-main-slider-width'];
                $slider_position    = $origin_theme['opt-main-slider-position'];
                $main_slides        = $origin_theme['opt-main-slides'];
                $slide_count        = count($main_slides);

                ($slider_width_value == 'fixedWidth') ? $slider_width = 'row' : $slider_width = '';

            $is_title   =   $instance['is_title'];

            
            
            echo $args['before_widget'];
            if ( ! empty( $instance['title'] ) && ($is_title == 'on')) {
                echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
            }
            
            ?>
                <div class='mainslider autoplay <?php echo $slider_position.' '.$slider_width; ?>'>
                    <?php for($slide=0; $slide < $slide_count; $slide++ ) { ?>
                            <div><img src='<?php echo $main_slides[$slide]["image"]; ?>' ?></div>
                    <?php } ?>
                </div>

            <?php
            echo $args['after_widget'];
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form( $instance ) {

            $title      = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Slider Title', 'text_domain' ); 
            $is_title   = esc_attr( $instance['is_title'] );

            ?>
            <?php if ($instance['is_title'] == 'on') { ?>
            <p>
                <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
                <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>
            <?php } ?>
            <p>
                <input class="checkbox" type="checkbox" <?php checked($instance['is_title'], 'on'); ?> 
                id="<?php echo $this->get_field_id('is_title'); ?>" 
                name="<?php echo $this->get_field_name('is_title'); ?>" /> 
                <label for="<?php echo $this->get_field_id('is_title'); ?>"><?php _e('Title'); ?></label>
            </p>
            <p><a href="<?php echo admin_url() . 'admin.php?page=origin&tab=1'; ?>" class="button">Change Settings</a></p>
            <?php 
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update( $new_instance, $old_instance ) {
            $instance = array();
            $instance['title']      = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['is_title']   = strip_tags( $new_instance['is_title'] );

            return $instance;
        }

    } // class Slider_Widget


    // register Slider_Widget widget
    function register_slider_widget() {
        register_widget( 'Slider_Widget' );
    }
    add_action( 'widgets_init', 'register_slider_widget' );

    
    function slider_plugin_scripts() {
        wp_enqueue_style( 'slider-style', PLUGIN_GENESIS_URL . 'assets/css/slick/slick.css', array(), '', 'all' );
        wp_enqueue_style( 'slider-theme-style', PLUGIN_GENESIS_URL . 'assets/css/slick/slick-theme.css', array(), '', 'all' );
        wp_enqueue_script( 'slider-script', PLUGIN_GENESIS_URL . 'assets/js/slick/slick.min.js', array( 'jquery' ), '', true );
        wp_enqueue_script( 'slider-custom-script', PLUGIN_GENESIS_URL . 'assets/js/slick/slick-custom.js', array( 'jquery' ), '', true );

    }
    add_action( 'wp_enqueue_scripts', 'slider_plugin_scripts');

    /* Slider Image Size */
    function dg_slider_image_size() {
        if ( function_exists( 'add_image_size' ) ) {
            add_image_size( 'main-slider-size', 1920, 1080, true );
        }
    }
    add_action( 'after_setup_theme', 'dg_slider_image_size', 11 );

    function dg_show_slider_image_size($sizes) {
        $sizes['main-slider-size'] = __( 'Slider Image', 'dizeno' );
        return $sizes;
    }
    add_filter('image_size_names_choose', 'dg_show_slider_image_size');

    

} //end if ($is_slider_enabled);
?>