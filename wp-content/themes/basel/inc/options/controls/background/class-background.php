<?php
/**
 * Set element background options and generate css.
 *
 * @package xts
 */

namespace XTS\Options\Controls;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

use XTS\Options\Field;

/**
 * Background properties control.
 */
class Background extends Field {

	/**
	 * Displays the field control HTML.
	 *
	 * @since 1.0.0
	 *
	 * @return void.
	 */
	public function render_control() {
		$value = $this->get_field_value();

		?>
			<div class="xts-bg-source">
				<div class="xts-bg-color">
					<input type="text" data-alpha="<?php echo isset( $this->args['alpha'] ) ? esc_attr( $this->args['alpha'] ) : 'true'; ?>" name="<?php echo esc_attr( $this->get_input_name( 'color' ) ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'color' ) ); ?>" />
				</div>
				<div class="xts-bg-image">
					<div class="xts-upload-preview<?php echo ( isset( $value['url'] ) && ! empty( $value['url'] ) ) ? ' xts-preview-shown' : ''; ?>">
						<?php if ( isset( $value['url'] ) && ! empty( $value['url'] ) ) : ?>
							<img src="<?php echo esc_url( $value['url'] ); ?>">
						<?php endif ?>
					</div>
				</div>
				<div class="xts-upload-btns">
					<button class="xts-btn xts-upload-btn"><?php esc_html_e( 'Upload', 'xts-theme' ); ?></button>
					<button class="xts-btn xts-remove-upload-btn<?php echo ( isset( $value['url'] ) && ! empty( $value['url'] ) ) ? ' xts-btn-shown' : ''; ?>"><?php esc_html_e( 'Remove', 'xts-theme' ); ?></button>
					<input type="hidden" class="xts-upload-input-url" name="<?php echo esc_attr( $this->get_input_name( 'url' ) ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'url' ) ); ?>" />
					<input type="hidden" class="xts-upload-input-id" name="<?php echo esc_attr( $this->get_input_name( 'id' ) ); ?>" value="<?php echo esc_attr( $this->get_field_value( 'id' ) ); ?>" />
				</div>
			</div>

			<div class="xts-bg-image-options">
				<select class="xts-bg-repeat" data-placeholder="<?php esc_attr_e( 'Background repeat', 'xts-theme' ); ?>" name="<?php echo esc_attr( $this->get_input_name( 'repeat' ) ); ?>">
					<option value=""></option>
					<option value="no-repeat" <?php selected( $this->get_field_value( 'repeat' ), 'no-repeat' ); ?>>No Repeat</option>
					<option value="repeat" <?php selected( $this->get_field_value( 'repeat' ), 'repeat' ); ?>>Repeat</option>
					<option value="repeat-x" <?php selected( $this->get_field_value( 'repeat' ), 'repeat-x' ); ?>>Repeat Horizontally</option>
					<option value="repeat-y" <?php selected( $this->get_field_value( 'repeat' ), 'repeat-y' ); ?>>Repeat Vertically</option>
					<option value="inherit" <?php selected( $this->get_field_value( 'repeat' ), 'inherit' ); ?>>Inherit</option>
				</select>
				<select class="xts-bg-size" data-placeholder="<?php esc_attr_e( 'Background size', 'xts-theme' ); ?>" name="<?php echo esc_attr( $this->get_input_name( 'size' ) ); ?>">
					<option value=""></option>
					<option value="cover" <?php selected( $this->get_field_value( 'size' ), 'cover' ); ?>>Cover</option>
					<option value="contain" <?php selected( $this->get_field_value( 'size' ), 'contain' ); ?>>Contain</option>
					<option value="inherit" <?php selected( $this->get_field_value( 'size' ), 'inherit' ); ?>>Inherit</option>
				</select>
				<select class="xts-bg-attachment" data-placeholder="<?php esc_attr_e( 'Background attachment', 'xts-theme' ); ?>" name="<?php echo esc_attr( $this->get_input_name( 'attachment' ) ); ?>">
					<option value=""></option>
					<option value="fixed" <?php selected( $this->get_field_value( 'attachment' ), 'fixed' ); ?>>Fixed</option>
					<option value="scroll" <?php selected( $this->get_field_value( 'attachment' ), 'scroll' ); ?>>Scroll</option>
					<option value="inherit" <?php selected( $this->get_field_value( 'attachment' ), 'inherit' ); ?>>Inherit</option>
				</select>
				<select class="xts-bg-position" data-placeholder="<?php esc_attr_e( 'Background position', 'xts-theme' ); ?>" name="<?php echo esc_attr( $this->get_input_name( 'position' ) ); ?>">
					<option value=""></option>
					<option value="left top" <?php selected( $this->get_field_value( 'position' ), 'left top' ); ?>>Left Top</option>
					<option value="left center" <?php selected( $this->get_field_value( 'position' ), 'left center' ); ?>>Left Center</option>
					<option value="left bottom" <?php selected( $this->get_field_value( 'position' ), 'left bottom' ); ?>>Left Bottom</option>
					<option value="center top" <?php selected( $this->get_field_value( 'position' ), 'center top' ); ?>>Center Top</option>
					<option value="center center" <?php selected( $this->get_field_value( 'position' ), 'center center' ); ?>>Center Center</option>
					<option value="center bottom" <?php selected( $this->get_field_value( 'position' ), 'center bottom' ); ?>>Center Bottom</option>
					<option value="right top" <?php selected( $this->get_field_value( 'position' ), 'right top' ); ?>>Right Top</option>
					<option value="right center" <?php selected( $this->get_field_value( 'position' ), 'right center' ); ?>>Right Center</option>
					<option value="right bottom" <?php selected( $this->get_field_value( 'position' ), 'right bottom' ); ?>>Right Bottom</option>
				</select>
			</div>

			<div class="xts-bg-preview"></div>

		<?php
	}

	/**
	 * Enqueue colorpicker lib.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker-alpha', BASEL_ASSETS . '/js/wp-color-picker-alpha.js', array( 'wp-color-picker' ), basel_get_theme_info( 'Version' ), true );
		wp_enqueue_script( 'select2', BASEL_ASSETS . '/js/select2.full.min.js', array(), basel_get_theme_info( 'Version' ), true );
	}

	/**
	 * Output field's css code based on the settings..
	 *
	 * @since 1.0.0
	 *
	 * @return  string $output Generated CSS code.
	 */
	public function css_output() {
		if ( ! isset( $this->args['selector'] ) || empty( $this->args['selector'] ) || empty( $this->get_field_value() ) || ( ! $this->get_field_value( 'color' ) && ! $this->get_field_value( 'url' ) && ! $this->get_field_value( 'repeat' ) && ! $this->get_field_value( 'size' ) && ! $this->get_field_value( 'attachment' ) && ! $this->get_field_value( 'position' ) ) ) {
			return;
		}

		$value = $this->get_field_value();

		$output = $this->args['selector'];

		$output .= '{';
		if ( isset( $value['color'] ) && ! empty( $value['color'] ) ) {
			$output .= 'background-color:' . $value['color'] . ';';
		}
		if ( isset( $value['url'] ) && ! empty( $value['url'] ) ) {
			$output .= 'background-image: url(' . $value['url'] . ');';
		}
		if ( isset( $value['repeat'] ) && ! empty( $value['repeat'] ) ) {
			$output .= 'background-repeat:' . $value['repeat'] . ';';
		}
		if ( isset( $value['size'] ) && ! empty( $value['size'] ) ) {
			$output .= 'background-size:' . $value['size'] . ';';
		}
		if ( isset( $value['attachment'] ) && ! empty( $value['attachment'] ) ) {
			$output .= 'background-attachment:' . $value['attachment'] . ';';
		}
		if ( isset( $value['position'] ) && ! empty( $value['position'] ) ) {
			$output .= 'background-position:' . $value['position'] . ';';
		}
		$output .= '}';

		return $output;
	}

	/**
	 * Check value URl and ID fields.
	 *
	 * @since 1.0.0
	 *
	 * @param  string or array $value Field value.
	 */
	public function validate( $value ) {
		if ( isset( $value['id'] ) ) {
			$attachment = wp_get_attachment_url( $value['id'] );

			if ( $attachment ) {
				$value['url'] = $attachment;
			}
		}

		return $value;
	}
}


