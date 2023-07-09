<?php
/**
 * Social widget.
 */
class Proframe_Social_Widget extends WP_Widget {

	/**
	 * Sets up the widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Set up the widget options.
		$widget_options = array(
			'classname'   => 'widget_social_icons',
			'description' => esc_html__( 'Display your social media icons.', 'proframe' ),
			'customize_selective_refresh' => true
		);

		// Create the widget.
		parent::__construct(
			'proframe-social',                                // $this->id_base
			esc_html__( '&raquo; Social Icons', 'proframe' ), // $this->name
			$widget_options                                  // $this->widget_options
		);

		$this->alt_option_name = 'widget_social_icons';
	}

	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Recent Posts widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		// Set up default value
		$title      = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Follow Us', 'proframe' );
		$facebook   = ( ! empty( $instance['facebook'] ) ) ? esc_url( $instance['facebook'] ) : '';
		$twitter    = ( ! empty( $instance['twitter'] ) ) ? esc_url( $instance['twitter'] ) : '';
		$gplus      = ( ! empty( $instance['gplus'] ) ) ? esc_url( $instance['gplus'] ) : '';
		$pinterest  = ( ! empty( $instance['pinterest'] ) ) ? esc_url( $instance['pinterest'] ) : '';
		$linkedin   = ( ! empty( $instance['linkedin'] ) ) ? esc_url( $instance['linkedin'] ) : '';
		$instagram  = ( ! empty( $instance['instagram'] ) ) ? esc_url( $instance['instagram'] ) : '';
		$dribbble   = ( ! empty( $instance['dribbble'] ) ) ? esc_url( $instance['dribbble'] ) : '';
		$github     = ( ! empty( $instance['github'] ) ) ? esc_url( $instance['github'] ) : '';
		$youtube    = ( ! empty( $instance['youtube'] ) ) ? esc_url( $instance['youtube'] ) : '';
		$vimeo      = ( ! empty( $instance['vimeo'] ) ) ? esc_url( $instance['vimeo'] ) : '';
		$snapchat   = ( ! empty( $instance['snapchat'] ) ) ? esc_url( $instance['snapchat'] ) : '';
		$medium     = ( ! empty( $instance['medium'] ) ) ? esc_url( $instance['medium'] ) : '';
		$flickr     = ( ! empty( $instance['flickr'] ) ) ? esc_url( $instance['flickr'] ) : '';
		$soundcloud = ( ! empty( $instance['soundcloud'] ) ) ? esc_url( $instance['soundcloud'] ) : '';
		$rss        = ( ! empty( $instance['rss'] ) ) ? esc_url( $instance['rss'] ) : '';

		// Output the theme's $before_widget wrapper.
		echo $args['before_widget'];

		// If the title not empty, display it.
		if ( $title ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $title, $instance, $this->id_base ) . $args['after_title'];
		}

			// Display the social icons.
			echo '<div class="social-icons">';
				if ( $facebook ) {
					echo '<a class="facebook" href="' . esc_url( $facebook ) . '"><i class="icon-facebook"></i></a>';
				}
				if ( $twitter ) {
					echo '<a class="twitter" href="' . esc_url( $twitter ) . '"><i class="icon-twitter"></i></a>';
				}
				if ( $gplus ) {
					echo '<a class="google-plus" href="' . esc_url( $gplus ) . '"><i class="icon-gplus"></i></a>';
				}
				if ( $pinterest ) {
					echo '<a class="pinterest" href="' . esc_url( $pinterest ) . '"><i class="icon-pinterest"></i></a>';
				}
				if ( $linkedin ) {
					echo '<a class="linkedin" href="' . esc_url( $linkedin ) . '"><i class="icon-linkedin"></i></a>';
				}
				if ( $instagram ) {
					echo '<a class="instagram" href="' . esc_url( $instagram ) . '"><i class="icon-instagram"></i></a>';
				}
				if ( $dribbble ) {
					echo '<a class="dribbble" href="' . esc_url( $dribbble ) . '"><i class="icon-dribbble"></i></a>';
				}
				if ( $github ) {
					echo '<a class="github" href="' . esc_url( $github ) . '"><i class="icon-github"></i></a>';
				}
				if ( $youtube ) {
					echo '<a class="youtube" href="' . esc_url( $youtube ) . '"><i class="icon-youtube"></i></a>';
				}
				if ( $vimeo ) {
					echo '<a class="vimeo" href="' . esc_url( $vimeo ) . '"><i class="icon-vimeo"></i></a>';
				}
				if ( $snapchat ) {
					echo '<a class="snapchat" href="' . esc_url( $snapchat ) . '"><i class="icon-snapchat"></i></a>';
				}
				if ( $medium ) {
					echo '<a class="medium" href="' . esc_url( $medium ) . '"><i class="icon-medium"></i></a>';
				}
				if ( $flickr ) {
					echo '<a class="flickr" href="' . esc_url( $flickr ) . '"><i class="icon-flickr"></i></a>';
				}
				if ( $soundcloud ) {
					echo '<a class="soundcloud" href="' . esc_url( $soundcloud ) . '"><i class="icon-soundcloud"></i></a>';
				}
				if ( $rss ) {
					echo '<a class="rss" href="' . esc_url( $rss ) . '"><i class="icon-rss"></i></a>';
				}
			echo '</div>';

		// Close the theme's widget wrapper.
		echo $args['after_widget'];

	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance               = $old_instance;
		$instance['title']      = sanitize_text_field( $new_instance['title'] );
		$instance['facebook']   = esc_url_raw( $new_instance['facebook'] );
		$instance['twitter']    = esc_url_raw( $new_instance['twitter'] );
		$instance['gplus']      = esc_url_raw( $new_instance['gplus'] );
		$instance['pinterest']  = esc_url_raw( $new_instance['pinterest'] );
		$instance['linkedin']   = esc_url_raw( $new_instance['linkedin'] );
		$instance['instagram']  = esc_url_raw( $new_instance['instagram'] );
		$instance['dribbble']   = esc_url_raw( $new_instance['dribbble'] );
		$instance['github']     = esc_url_raw( $new_instance['github'] );
		$instance['youtube']    = esc_url_raw( $new_instance['youtube'] );
		$instance['vimeo']      = esc_url_raw( $new_instance['vimeo'] );
		$instance['snapchat']   = esc_url_raw( $new_instance['snapchat'] );
		$instance['medium']     = esc_url_raw( $new_instance['medium'] );
		$instance['flickr']     = esc_url_raw( $new_instance['flickr'] );
		$instance['soundcloud'] = esc_url_raw( $new_instance['soundcloud'] );
		$instance['rss']        = esc_url_raw( $new_instance['rss'] );
		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title      = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : esc_html__( 'Follow Us', 'proframe' );
		$facebook   = isset( $instance['facebook'] ) ? esc_url( $instance['facebook'] ) : '';
		$twitter    = isset( $instance['twitter'] ) ? esc_url( $instance['twitter'] ) : '';
		$gplus      = isset( $instance['gplus'] ) ? esc_url( $instance['gplus'] ) : '';
		$pinterest  = isset( $instance['pinterest'] ) ? esc_url( $instance['pinterest'] ) : '';
		$linkedin   = isset( $instance['linkedin'] ) ? esc_url( $instance['linkedin'] ) : '';
		$instagram  = isset( $instance['instagram'] ) ? esc_url( $instance['instagram'] ) : '';
		$dribbble   = isset( $instance['dribbble'] ) ? esc_url( $instance['dribbble'] ) : '';
		$github     = isset( $instance['github'] ) ? esc_url( $instance['github'] ) : '';
		$youtube    = isset( $instance['youtube'] ) ? esc_url( $instance['youtube'] ) : '';
		$vimeo      = isset( $instance['vimeo'] ) ? esc_url( $instance['vimeo'] ) : '';
		$snapchat   = isset( $instance['snapchat'] ) ? esc_url( $instance['snapchat'] ) : '';
		$medium     = isset( $instance['medium'] ) ? esc_url( $instance['medium'] ) : '';
		$flickr     = isset( $instance['flickr'] ) ? esc_url( $instance['flickr'] ) : '';
		$soundcloud = isset( $instance['soundcloud'] ) ? esc_url( $instance['soundcloud'] ) : '';
		$rss        = isset( $instance['rss'] ) ? esc_url( $instance['rss'] ) : '';
	?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php esc_html_e( 'Title', 'proframe' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>">
				<?php esc_html_e( 'Facebook', 'proframe' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" value="<?php echo $facebook; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>">
				<?php esc_html_e( 'Twitter', 'proframe' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" value="<?php echo $twitter; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'gplus' ); ?>">
				<?php esc_html_e( 'Google Plus', 'proframe' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'gplus' ); ?>" name="<?php echo $this->get_field_name( 'gplus' ); ?>" value="<?php echo $gplus; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'pinterest' ); ?>">
				<?php esc_html_e( 'Pinterest', 'proframe' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" value="<?php echo $pinterest; ?>" placeholder="<?php echo  esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'linkedin' ); ?>">
				<?php esc_html_e( 'LinkedIn', 'proframe' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'linkedin' ); ?>" name="<?php echo $this->get_field_name( 'linkedin' ); ?>" value="<?php echo $linkedin; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'instagram' ); ?>">
				<?php esc_html_e( 'Instagram', 'proframe' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" value="<?php echo $instagram; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'dribbble' ); ?>">
				<?php esc_html_e( 'Dribbble', 'proframe' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'dribbble' ); ?>" name="<?php echo $this->get_field_name( 'dribbble' ); ?>" value="<?php echo $dribbble; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'github' ); ?>">
				<?php esc_html_e( 'Github', 'proframe' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'github' ); ?>" name="<?php echo $this->get_field_name( 'github' ); ?>" value="<?php echo $github; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'youtube' ); ?>">
				<?php esc_html_e( 'Youtube', 'proframe' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" value="<?php echo $youtube; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'vimeo' ); ?>">
				<?php esc_html_e( 'Vimeo', 'proframe' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'vimeo' ); ?>" name="<?php echo $this->get_field_name( 'vimeo' ); ?>" value="<?php echo $vimeo; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'snapchat' ); ?>">
				<?php esc_html_e( 'Snapchat', 'proframe' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'snapchat' ); ?>" name="<?php echo $this->get_field_name( 'snapchat' ); ?>" value="<?php echo $snapchat; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'medium' ); ?>">
				<?php esc_html_e( 'Medium', 'proframe' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'medium' ); ?>" name="<?php echo $this->get_field_name( 'medium' ); ?>" value="<?php echo $medium; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'flickr' ); ?>">
				<?php esc_html_e( 'Flickr', 'proframe' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'flickr' ); ?>" name="<?php echo $this->get_field_name( 'flickr' ); ?>" value="<?php echo $flickr; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'soundcloud' ); ?>">
				<?php esc_html_e( 'Soundcloud', 'proframe' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'soundcloud' ); ?>" name="<?php echo $this->get_field_name( 'soundcloud' ); ?>" value="<?php echo $soundcloud; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'rss' ); ?>">
				<?php esc_html_e( 'RSS Feed', 'proframe' ); ?>
			</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" value="<?php echo $rss; ?>" placeholder="<?php echo esc_attr( 'http://' ); ?>" />
		</p>

	<?php

	}

}
