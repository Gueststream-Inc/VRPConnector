<?php

namespace Gueststream\Widgets;

// Widgets
class vrpSearchFormWidget extends \WP_Widget {

	public function __construct() {
		parent::__construct( 'vrpsearch_widget', 'VRPConnector - Search' );
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$showAdvanced = $instance['showAdvanced'];
		echo $before_widget;
		?>
		<div class='vrpsearch-widget'>
			<?php if ( ! empty( $title ) ) { ?> <h3 class='widget-title'><?php echo $title ?></h3> <?php } ?>
			<?php
			if ( empty( $showAdvanced ) ) {
				echo do_shortcode( '[vrpSearchForm]' );
			} else {
				echo do_shortcode( '[vrpAdvancedSearchForm]' );
			}
			?>

		</div>
		<?php
		echo $after_widget;
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['showAdvanced'] = strip_tags( $new_instance['showAdvanced'] );
		return $instance;
	}

	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			$title = '';
		}
		if ( isset( $instance['showAdvanced'] ) ) {
			$showAdvanced = $instance['showAdvanced'];
		} else {
			$showAdvanced = '';
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />       
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'showAdvanced' ); ?>"><?php _e( 'Show Advanced Form:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'showAdvanced' ); ?>" name="<?php echo $this->get_field_name( 'showAdvanced' ); ?>" type="checkbox" value="1" <?php if ( $showAdvanced ) { echo 'checked';}?> />       
		</p>
		<?php
	}

}
