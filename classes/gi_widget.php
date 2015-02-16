<?php

class gi_weather_widget extends WP_Widget {

    function gi_weather_widget() {
        // Instantiate the parent object
        parent::__construct( 'gi-weather', __('GI Weather', 'giw' ),
            array( 'description' => __( 'Display Weather temperature and Weather status', 'giw' ))
        );
    }

    function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $args['before_widget'];
        if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
        
		
		include(dirname(dirname(__FILE__)). '/templates/widget.php');

        echo $args['after_widget'];

    }

    function update( $new_instance, $old_instance ) {
        // Save widget options
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }

    function form( $instance ) {
        // Output admin widget options form
        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }else {
            $title = __( 'GI Weather', 'giw' );
        }
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
    <?php
    }
}


function gi_weather_widget_register_widgets() {
    register_widget( 'gi_weather_widget' );
}
add_action( 'widgets_init', 'gi_weather_widget_register_widgets' );


?>