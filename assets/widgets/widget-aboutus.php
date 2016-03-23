<?php

class About_Us_Widget extends WP_Widget {

    var $image_field = 'image';  // the image field ID
 
    public function __construct() {
     
        parent::__construct(
            'dizeno_about_us_widget',
            __( 'Dizeno - About Us Widget', 'dizenotextdomain' ),
            array(
                'classname'   => 'dizenotext_widget',
                'description' => __( 'A widget to display about us text and image.', 'dizenotextdomain' )
                )
        );
       
        load_plugin_textdomain( 'dizenotextdomain', false, basename( dirname( __FILE__ ) ) . '/languages' );
       
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

        
        extract( $args );
         
        $about_title        = $instance['about_title'];  
        $about_description  = $instance['about_description'];  
        $image_id           = $instance['image_id'];
        
        
        
        
        echo $before_widget;
        

        ?>

            <div class="about-us">
                <div class="row">
                    <div class="columns large-7">
                        <h3 class="page-title">
                            <?php echo $about_title; ?>
                        </h3>
                        <article>
                            <?php echo $about_description; ?>
                        </article>
                    </div>
                    <div class="columns large-offset-1 large-4">
                        <?php echo wp_get_attachment_image($image_id, 'full', false, array('id'=>$image_id)) ?>
                    </div>
                </div>
            </div>
            
           

        <?php

        echo $after_widget;

         
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
         
        $instance = $old_instance;
         
        $instance['about_title']        = strip_tags( $new_instance['about_title'] );
        $instance['about_description']  = strip_tags( $new_instance['about_description'] );
        $instance['image_id']           = strip_tags( $new_instance['image_id'] );
        
        
         
        return $instance;
         
    }
  
    /**
      * Back-end widget form.
      *
      * @see WP_Widget::form()
      *
      * @param array $instance Previously saved values from database.
      */
    public function form( $instance ) {    
    

        $about_title        = esc_attr( isset( $instance['about_title'] ) ? $instance['about_title'] : '' );  
        $about_description  = esc_attr( isset( $instance['about_description'] ) ? $instance['about_description'] : '' );  
        $image_id           = esc_attr( isset( $instance['image_id'] ) ? $instance['image_id'] : '' );  
        
        
        
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('about_title'); ?>"><?php _e('Title: '); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('about_title'); ?>" name="<?php echo $this->get_field_name('about_title'); ?>" 
            type="text" value="<?php echo $about_title; ?>" size="3" />
        </p>
        
        <p>
            <label for="<?php echo $this->get_field_id('about_description'); ?>"><?php _e('Description: '); ?></label> 
            <textarea class="widefat" row="50" id="<?php echo $this->get_field_id('about_description'); ?>" name="<?php echo $this->get_field_name('about_description'); ?>"><?php echo $about_description; ?></textarea>
        </p>

        <p>
            <input class="widefat" id="<?php echo $this->get_field_id('image_id'); ?>_text" name="<?php echo $this->get_field_name('image_id'); ?>" 
            type="text" value="<?php echo $image_id; ?>" size="3" />
            <?php echo wp_get_attachment_image($image_id,'thumbnail', false, array('id'=>$image_id, '')); ?><br><br>
            <input type="button" class="button" id="<?php echo $this->get_field_id('image_id'); ?>_button" value="Upload Image">
        </p>
        
        <?php 
            $button     = $this->get_field_id('image_id').'_button'; 
            $text_input = $this->get_field_id('image_id').'_text'; 
        ?>

        <script type="text/javascript">
        jQuery(document).ready(function($) {

            var button_id       = $('#<?php echo $button; ?>');    
            var text_input_id   = $('#<?php echo $text_input; ?>'); 


            text_input_id.hide();

            button_id.click(function() {
                open_media_uploader_image(this.id);
            });
            function open_media_uploader_image(bn) {
                media_uploader = wp.media({
                    frame:    "post", 
                    state:    "insert", 
                    multiple: false
                });

                
                media_uploader.on("insert", function(){
                    var json = media_uploader.state().get("selection").first().toJSON();

                    var image_url       = json.url;
                    var image_caption   = json.caption;
                    var image_title     = json.title;
                    var image_id        = json.id;

                    text_input_id.val(image_id);
                    text_input_id.after("<img src=" +image_url+" id="+image_id+" style='width:100%; max-width:100px;'>");
                });

                media_uploader.open();
           
            }
        });
        </script>
        
     
    <?php 
    }
     
}
 
/* Register the widget */
add_action( 'widgets_init', function(){
     register_widget( 'About_Us_Widget' );
});?>