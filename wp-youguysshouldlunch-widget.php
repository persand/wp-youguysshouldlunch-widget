<?php
/*
Plugin Name: You guys should lunch Widget
Plugin URI: http://www.youguysshouldlunch.com/widget
Description: Widget for www.youguysshouldlunch.com.
Version: 1.0
Author: Per Sandström
Author URI: http://www.helloper.com
*/
class YouguysshouldlunchWidget extends WP_Widget {
  function YouguysshouldlunchWidget() {
    $widget_ops = array( 'classname' => 'youguysshouldlunch-widget', 'description' => __( 'Widget for www.youguysshouldlunch.com.', 'YouguysshouldlunchWidget' ) );

    $this->WP_Widget( 'YouguysshouldlunchWidget', 'Youguysshouldlunch', $widget_ops );

    wp_register_style( 'youguysshouldlunch-widget', plugins_url( 'css/youguysshouldlunch.css' , __FILE__ ) );
    wp_enqueue_style( 'youguysshouldlunch-widget' );
  }
 
  function form( $instance ) {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );

    $lunch_dates = ( empty( $instance['lunch_dates'] ) ) ? '' : esc_attr( $instance['lunch_dates'] );
    $your_name = ( empty( $instance['your_name'] ) ) ? '' : esc_attr( $instance['your_name'] );
    $linkedin_url = ( empty( $instance['linkedin_url'] ) ) ? '' : esc_attr( $instance['linkedin_url'] );
    $disable_background_color = ( empty( $instance['disable_background_color'] ) ) ? '' : esc_attr( $instance['disable_background_color'] );
    ?>
    <p>
      <label for="<?php echo $this->get_field_id( 'lunch_dates' ); ?>">
        <?php _e( 'People on my wishlist:', 'YouguysshouldlunchWidget' ); ?>
        <input class="widefat" id="<?php echo $this->get_field_id( 'lunch_dates' ); ?>" name="<?php echo $this->get_field_name( 'lunch_dates' ); ?>" type="text" value="<?php echo $lunch_dates; ?>" />
      </label>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'your_name' ); ?>">
        <?php _e( 'My name:', 'YouguysshouldlunchWidget' ); ?>
        <input class="widefat" id="<?php echo $this->get_field_id( 'your_name' ); ?>" name="<?php echo $this->get_field_name( 'your_name' ); ?>" type="text" value="<?php echo $your_name; ?>" />
      </label>
    </p>

    <p>
      <label for="<?php echo $this->get_field_id( 'linkedin_url' ); ?>">
        <?php _e( 'LinkedIn URL:', 'YouguysshouldlunchWidget' ); ?>
        <input class="widefat" id="<?php echo $this->get_field_id( 'linkedin_url' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_url' ); ?>" type="text" value="<?php echo $linkedin_url; ?>" />
      </label>
      <?php _e( 'E.g. <em>http://www.linkedin.com/in/jonaslarsson</em>.', 'YouguysshouldlunchWidget' ); ?>
    </p>

    <?php $checked = empty( $disable_background_color ) ? '' : ' checked="checked"' ; ?> 
    <p>
      <input type="checkbox" value="true" id="<?php echo $this->get_field_id( 'disable_background_color' ); ?>" name="<?php echo $this->get_field_name( 'disable_background_color' ); ?>"<?php echo $checked; ?> />
      <label for="<?php echo $this->get_field_id( 'disable_background_color' ); ?>"><?php _e( 'Disable background color', 'YouguysshouldlunchWidget' ); ?></label>
    </p>
    <?php
  }
 
  function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['lunch_dates'] = $new_instance['lunch_dates'];
    $instance['your_name'] = $new_instance['your_name'];
    $instance['linkedin_url'] = $new_instance['linkedin_url'];
    $instance['disable_background_color'] = $new_instance['disable_background_color'];
    return $instance;
  }
 
  function widget( $args, $instance ) {
    extract( $args, EXTR_SKIP );

    $lunch_dates = empty( $instance['lunch_dates'] ) ? '' : esc_attr( $instance['lunch_dates'] );
    $your_name = empty( $instance['your_name'] ) ? '' : esc_attr( $instance['your_name'] );
    $linkedin_url = empty( $instance['linkedin_url'] ) ? '' : esc_attr( $instance['linkedin_url'] );
    $disable_background_color = empty ( $instance['disable_background_color'] ) ? 'false' : $instance['disable_background_color'];

    echo $before_widget;

    if ( $disable_background_color == 'false' ) {
      $widget_classes = 'widget-lunchaihop-background widget-lunchaihop-clearfix';
    } else {
      $widget_classes = 'widget-lunchaihop-clearfix';
    }

    echo sprintf( '<div class="%s">', $widget_classes );

    echo $before_title;
    echo 'Lunchaihop';
    echo $after_title;

    echo sprintf ( '<a href="http://www.youguysshouldlunch.com"><img class="widget-youguysshouldlunch-logo" src="%s" alt="You guys should lunch"></a>', plugins_url( 'img/youguysshouldlunch-logo.png' , __FILE__ ) );

    if ( !empty( $lunch_dates ) ) {
      echo '<p class="widget-youguysshouldlunch-wishlist">'.__( 'My lunch wishlist:', 'YouguysshouldlunchWidget' ).'<br>'.$lunch_dates.'</p>';
    }

    echo __( 'Who should I <a href="http://www.youguysshouldlunch.com">lunch with</a>?', 'YouguysshouldlunchWidget' );

    if ( !empty( $linkedin_url ) ) {
      if ( !empty( $your_name ) ) {
        $your_name = ' data-text="'.$your_name.'" ';
      } else {
        $your_name = '';
      }

      echo sprintf( '<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script><script type="IN/MemberProfile" data-id="%s" data-format="click"%sdata-related="false"></script>', $linkedin_url, $your_name );
    }
    
    echo sprintf( '</div><!-- / %s -->', $widget_classes );
    
    echo $after_widget;
  }
}

add_action( 'widgets_init', create_function('', 'return register_widget("YouguysshouldlunchWidget");') );
?>