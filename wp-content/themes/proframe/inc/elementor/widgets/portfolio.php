<?php
/**
 * Portfolio widgets
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Portfolify_Widget_Portfolio extends Widget_Base {

	public function get_name() {
		return 'proframe-portfolio';
	}

	public function get_title() {
		return esc_html__( 'Portfolio', 'proframe' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_portfolio',
			[
				'label' => esc_html__( 'Portfolio', 'proframe' ),
			]
		);

		$this->add_control(
			'count',
			[
				'label'         => esc_html__( 'Posts Per Page', 'proframe' ),
				'description'   => esc_html__( 'You can enter "-1" to display all portfolio.', 'proframe' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => '6',
				'label_block'   => true,
			]
		);

		$this->add_control(
			'order',
			[
				'label'         => esc_html__( 'Order', 'proframe' ),
				'type'          => Controls_Manager::SELECT,
				'default'       => '',
				'options'       => [
					''          => esc_html__( 'Default', 'proframe' ),
					'DESC'      => esc_html__( 'DESC', 'proframe' ),
					'ASC'       => esc_html__( 'ASC', 'proframe' ),
				],
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'         => esc_html__( 'Order By', 'proframe' ),
				'type'          => Controls_Manager::SELECT,
				'default'       => '',
				'options'       => [
					''              => esc_html__( 'Default', 'proframe' ),
					'date'          => esc_html__( 'Date', 'proframe' ),
					'title'         => esc_html__( 'Title', 'proframe' ),
					'name'          => esc_html__( 'Name', 'proframe' ),
					'modified'      => esc_html__( 'Modified', 'proframe' ),
					'author'        => esc_html__( 'Author', 'proframe' ),
					'rand'          => esc_html__( 'Random', 'proframe' ),
					'ID'            => esc_html__( 'ID', 'proframe' ),
					'comment_count' => esc_html__( 'Comment Count', 'proframe' ),
					'menu_order'    => esc_html__( 'Menu Order', 'proframe' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_elements',
			[
				'label' => esc_html__( 'Elements', 'proframe' )
			]
		);

		$this->add_control(
			'title',
			[
				'label'         => esc_html__( 'Display Title', 'proframe' ),
				'type'          => Controls_Manager::SWITCHER,
				'default'       => 'show',
				'label_on'      => esc_html__( 'Hide', 'proframe' ),
				'label_off'     => esc_html__( 'Show', 'proframe' ),
				'return_value'  => 'show',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_columns',
			[
				'label'         => esc_html__( 'Columns', 'proframe' ),
				'tab'           => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'columns',
			[
				'label'         => esc_html__( 'Columns', 'proframe' ),
				'type'          => Controls_Manager::SELECT,
				'default'       => 'proframe-three-columns',
				'options'       => [
					'proframe-two-columns'   => esc_html__( 'Two columns', 'proframe' ),
					'proframe-three-columns' => esc_html__( 'Three columns', 'proframe' ),
					'proframe-four-columns'  => esc_html__( 'Four columns', 'proframe' ),
				],
			]
		);

		$this->add_control(
			'image_size',
			[
				'label'         => esc_html__( 'Image Size', 'proframe' ),
				'type'          => Controls_Manager::SELECT,
				'default'       => 'proframe-portfolio',
				'options'       => $this->get_img_sizes(),
			]
		);

		$this->end_controls_section();

	}

	public function get_img_sizes() {
		global $_wp_additional_image_sizes;

		$sizes = array();
		$get_intermediate_image_sizes = get_intermediate_image_sizes();

		// Create the full array with sizes and crop info
		foreach( $get_intermediate_image_sizes as $_size ) {
			if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
				$sizes[ $_size ]['width'] 	= get_option( $_size . '_size_w' );
				$sizes[ $_size ]['height'] 	= get_option( $_size . '_size_h' );
				$sizes[ $_size ]['crop'] 	= (bool) get_option( $_size . '_crop' );
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size ] = array(
					'width' 	=> $_wp_additional_image_sizes[ $_size ]['width'],
					'height' 	=> $_wp_additional_image_sizes[ $_size ]['height'],
					'crop' 		=> $_wp_additional_image_sizes[ $_size ]['crop'],
				);
			}
		}

		$image_sizes = array();

		foreach ( $sizes as $size_key => $size_attributes ) {
			$image_sizes[ $size_key ] = ucwords( str_replace( '_', ' ', $size_key ) ) . sprintf( ' - %d x %d', $size_attributes['width'], $size_attributes['height'] );
		}

		$image_sizes['full'] 	= _x( 'Full', 'Image Size Control', 'proframe' );

		return $image_sizes;
	}

	protected function render() {
		$settings = $this->get_settings();

		// Vars
		$posts_per_page = $settings['count'];
		$order 			= $settings['order'];
		$orderby  		= $settings['orderby'];

		$args = array(
			'post_type'         => 'portfolio',
			'posts_per_page'    => $posts_per_page,
			'order'             => $order,
			'orderby'           => $orderby
		);

		// Build the WordPress query
		$portfolio = new \WP_Query( $args );

		// Output posts
		if ( $portfolio->have_posts() ) :

			// Vars
			$title    = $settings['title'];
			$columns  = $settings['columns'];

			// Image size
			$img_size = $settings['image_size'];
			$img_size = $img_size ? $img_size : 'proframe-portfolio';

			// Wrapper classes
			$wrap_classes = array( 'proframe-portfolio', 'proframe-items' );
			$wrap_classes[] = $columns;
			$wrap_classes = implode( ' ', $wrap_classes );
			?>

			<div class="<?php echo esc_attr( $wrap_classes ); ?>">

				<?php

				// Start loop
				while ( $portfolio->have_posts() ) : $portfolio->the_post(); ?>

					<article <?php post_class( 'proframe-item' ); ?>>

						<div class="thumbnail">
							<a class="post-thumbnail" href="<?php the_permalink(); ?>">

								<?php
									the_post_thumbnail( $img_size, array(
										'alt' => the_title_attribute( array(
											'echo' => false,
										) ),
									) );
								?>

								<span class="thumbnail-overlay">
									<span class="overlay-content">

										<?php if ( $title == 'show' ) : ?>
											<?php the_title( '<h5 class="overlay-title">', '</h5>' ); ?>
										<?php endif; ?>

									</span>
								</span>

							</a>
						</div>

					</article>

				<?php
				// End entry loop
				endwhile; ?>

				<span class="proframe-archive-link">
					<a href="<?php echo esc_url( get_post_type_archive_link( 'portfolio' ) ); ?>" class="archive-link"><?php esc_html_e( 'View More', 'proframe' ); ?></a>
				</span>

			</div><!-- .proframe-portfolio -->

			<?php
			// Reset the post data to prevent conflicts with WP globals
			wp_reset_postdata();

		// If no posts are found display message
		else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', 'proframe' ); ?></p>

		<?php
		// End post check
		endif; ?>

	<?php
	}

}

Plugin::instance()->widgets_manager->register_widget_type( new Portfolify_Widget_Portfolio() );
