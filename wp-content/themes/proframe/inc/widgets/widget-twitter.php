<?php
/**
 * Twiter Timeline widget.
 * Based on Jetpack Twitter Timeline widget.
 */
class Proframe_Twitter_Widget extends WP_Widget {

	/**
	 * Sets up the widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Set up the widget options.
		$widget_options = array(
			'classname'   => 'proframe_twitter_timeline',
			'description' => esc_html__( 'Display an official Twitter Embedded Timeline widget.', 'proframe' ),
			'customize_selective_refresh' => true
		);

		// Create the widget.
		parent::__construct(
			'proframe-twitter-timeline',                          // $this->id_base
			esc_html__( '&raquo; Twitter Timeline', 'proframe' ), // $this->name
			$widget_options                                      // $this->widget_options
		);

		$this->alt_option_name = 'proframe_twitter_timeline';

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
		$instance['lang']  = substr( strtoupper( get_locale() ), 0, 2 );

		echo $args['before_widget'];

		$title = isset( $instance['title'] ) ? $instance['title'] : '';

		$title = apply_filters( 'widget_title', $title );
		if ( ! empty( $title ) ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		// Start tag output
		// This tag is transformed into the widget markup by Twitter's
		echo '<a class="twitter-timeline"';

		$data_attribs = array(
			'width',
			'height',
			'theme',
			'link-color',
			'border-color',
			'tweet-limit',
			'lang'
		);
		foreach ( $data_attribs as $att ) {
			if ( ! empty( $instance[ $att ] ) && ! is_array( $instance[ $att ] ) ) {
				echo ' data-' . esc_attr( $att ) . '="' . esc_attr( $instance[ $att ] ) . '"';
			}
		}

		if ( ! empty( $instance['chrome'] ) && is_array( $instance['chrome'] ) ) {
			echo ' data-chrome="' . esc_attr( join( ' ', $instance['chrome'] ) ) . '"';
		}

		if ( $instance['username'] ) {
			echo ' href="https://twitter.com/' . esc_attr( $instance['username'] ) . '"';
		}

		// End tag output
		echo '><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>' . esc_html__( 'My Tweets', 'proframe' ) . '</a>';
		// End tag output

		echo $args['after_widget'];
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
		$instance                  = array();
		$instance['title']         = sanitize_text_field( $new_instance['title'] );

		$width = (int) $new_instance['width'];
		if ( $width ) {
			// From publish.twitter.com: 220 <= width <= 1200
			$instance['width'] = min( max( $width, 220 ), 1200 );
		} else {
			$instance['width'] = '';
		}

		$height = (int) $new_instance['height'];
		if ( $height ) {
			// From publish.twitter.com: height >= 200
			$instance['height'] = max( $height, 200 );
		} else {
			$instance['height'] = '';
		}

		$tweet_limit = (int) $new_instance['tweet-limit'];
		if ( $tweet_limit ) {
			$instance['tweet-limit'] = min( max( $tweet_limit, 1 ), 20 );
		} else {
			$instance['tweet-limit'] = null;
		}

		$instance['username'] = sanitize_text_field( $new_instance['username'] );

		$hex_regex = '/#([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?\b/';
		foreach ( array( 'link-color', 'border-color' ) as $color ) {
			$new_color = sanitize_text_field( $new_instance[ $color ] );
			if ( preg_match( $hex_regex, $new_color ) ) {
				$instance[ $color ] = $new_color;
			}

		}

		$instance['theme'] = 'light';
		if ( in_array( $new_instance['theme'], array( 'light', 'dark' ) ) ) {
			$instance['theme'] = $new_instance['theme'];
		}

		$instance['chrome'] = array();
		$chrome_settings = array(
			'noheader',
			'nofooter',
			'noborders',
			'transparent',
			'noscrollbar',
		);
		if ( isset( $new_instance['chrome'] ) ) {
			foreach ( $new_instance['chrome'] as $chrome ) {
				if ( in_array( $chrome, $chrome_settings ) ) {
					$instance['chrome'][] = $chrome;
				}
			}
		}

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
		$defaults = array(
			'title'        => esc_html__( 'Follow me on Twitter', 'proframe' ),
			'width'        => '',
			'height'       => '200',
			'username'     => '',
			'link-color'   => '#f96e5b',
			'border-color' => '#e8e8e8',
			'theme'        => 'light',
			'chrome'       => array(),
			'tweet-limit'  => 3,
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'proframe' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php esc_html_e( 'Width (px):', 'proframe' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" type="text" value="<?php echo esc_attr( $instance['width'] ); ?>" />
		</p>

		 <p>
			<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php esc_html_e( 'Height (px):', 'proframe' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" type="text" value="<?php echo esc_attr( $instance['height'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'tweet-limit' ); ?>"><?php esc_html_e( '# of Tweets Shown:', 'proframe' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'tweet-limit' ); ?>" name="<?php echo $this->get_field_name( 'tweet-limit' ); ?>" type="number" min="1" max="20" value="<?php echo esc_attr( $instance['tweet-limit'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'username' ); ?>"><?php esc_html_e( 'Username:', 'proframe' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'username' ); ?>" name="<?php echo $this->get_field_name( 'username' ); ?>" type="text" value="<?php echo esc_attr( $instance['username'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'chrome-noheader' ); ?>"><?php esc_html_e( 'Layout Options:', 'proframe' ); ?></label><br />
			<input type="checkbox"<?php checked( in_array( 'noheader', $instance['chrome'] ) ); ?> id="<?php echo $this->get_field_id( 'chrome-noheader' ); ?>" name="<?php echo $this->get_field_name( 'chrome' ); ?>[]" value="noheader" /> <label for="<?php echo $this->get_field_id( 'chrome-noheader' ); ?>"><?php esc_html_e( 'No Header', 'proframe' ); ?></label><br />
			<input type="checkbox"<?php checked( in_array( 'nofooter', $instance['chrome'] ) ); ?> id="<?php echo $this->get_field_id( 'chrome-nofooter' ); ?>" name="<?php echo $this->get_field_name( 'chrome' ); ?>[]" value="nofooter" /> <label for="<?php echo $this->get_field_id( 'chrome-nofooter' ); ?>"><?php esc_html_e( 'No Footer', 'proframe' ); ?></label><br />
			<input type="checkbox"<?php checked( in_array( 'noborders', $instance['chrome'] ) ); ?> id="<?php echo $this->get_field_id( 'chrome-noborders' ); ?>" name="<?php echo $this->get_field_name( 'chrome' ); ?>[]" value="noborders" /> <label for="<?php echo $this->get_field_id( 'chrome-noborders' ); ?>"><?php esc_html_e( 'No Borders', 'proframe' ); ?></label><br />
			<input type="checkbox"<?php checked( in_array( 'noscrollbar', $instance['chrome'] ) ); ?> id="<?php echo $this->get_field_id( 'chrome-noscrollbar' ); ?>" name="<?php echo $this->get_field_name( 'chrome' ); ?>[]" value="noscrollbar" /> <label for="<?php echo $this->get_field_id( 'chrome-noscrollbar' ); ?>"><?php esc_html_e( 'No Scrollbar', 'proframe' ); ?></label><br />
			<input type="checkbox"<?php checked( in_array( 'transparent', $instance['chrome'] ) ); ?> id="<?php echo $this->get_field_id( 'chrome-transparent' ); ?>" name="<?php echo $this->get_field_name( 'chrome' ); ?>[]" value="transparent" /> <label for="<?php echo $this->get_field_id( 'chrome-transparent' ); ?>"><?php esc_html_e( 'Transparent Background', 'proframe' ); ?></label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'link-color' ); ?>"><?php esc_html_e( 'Link Color (hex):', 'proframe' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'link-color' ); ?>" name="<?php echo $this->get_field_name( 'link-color' ); ?>" type="text" value="<?php echo esc_attr( $instance['link-color'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'border-color' ); ?>"><?php esc_html_e( 'Border Color (hex):', 'proframe' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'border-color' ); ?>" name="<?php echo $this->get_field_name( 'border-color' ); ?>" type="text" value="<?php echo esc_attr( $instance['border-color'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'theme' ); ?>"><?php esc_html_e( 'Timeline Theme:', 'proframe' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'theme' ); ?>" id="<?php echo $this->get_field_id( 'theme' ); ?>" class="widefat">
				<option value="light"<?php selected( $instance['theme'], 'light' ); ?>><?php esc_html_e( 'Light', 'proframe' ); ?></option>
				<option value="dark"<?php selected( $instance['theme'], 'dark' ); ?>><?php esc_html_e( 'Dark', 'proframe' ); ?></option>
			</select>
		</p>
	<?php
	}
}
