<?php
/**
 * Slides widgets
 */

namespace Elementor;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Proframe_Widget_Slides extends Widget_Base {

	public function get_name() {
		return 'proframe-slides';
	}

	public function get_title() {
		return esc_html__( 'Slides', 'proframe' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_keywords() {
		return [ 'image', 'photo', 'visual', 'carousel', 'slider' ];
	}

	public function get_script_depends() {
		return [ 'proframe-elementor', 'proframe-owl' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'section_slides',
			[
				'label' => esc_html__( 'Slides', 'proframe' ),
			]
		);

		$this->add_control(
			'count',
			[
				'label'         => esc_html__( 'Posts Per Page', 'proframe' ),
				'description'   => esc_html__( 'You can enter "-1" to display all items.', 'proframe' ),
				'type'          => Controls_Manager::TEXT,
				'default'       => '5',
				'label_block'   => true,
			]
		);

		$this->add_control(
			'post_type',
			[
				'label'         => esc_html__( 'Post Type', 'proframe' ),
				'type'          => Controls_Manager::SELECT,
				'default'       => 'portfolio',
				'options'       => [
					'portfolio' => esc_html__( 'Portfolio', 'proframe' ),
					'post'      => esc_html__( 'Post', 'proframe' ),
				],
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
			'section_slides_elements',
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

		$this->add_control(
			'category',
			[
				'label'         => esc_html__( 'Display Categories', 'proframe' ),
				'type'          => Controls_Manager::SWITCHER,
				'default'       => 'show',
				'label_on'      => esc_html__( 'Hide', 'proframe' ),
				'label_off'     => esc_html__( 'Show', 'proframe' ),
				'return_value'  => 'show',
			]
		);

		$this->add_control(
			'view_more',
			[
				'label'         => esc_html__( 'Display View More', 'proframe' ),
				'type'          => Controls_Manager::SWITCHER,
				'default'       => 'show',
				'label_on'      => esc_html__( 'Hide', 'proframe' ),
				'label_off'     => esc_html__( 'Show', 'proframe' ),
				'return_value'  => 'show',
			]
		);

		$this->add_control(
			'view_more_text',
			[
				'label'          => esc_html__( 'View More Text', 'proframe' ),
				'type'           => Controls_Manager::TEXT,
				'default'        => esc_html__( 'View More', 'proframe' )
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slides_category_color',
			[
				'label'         => esc_html__( 'Category', 'proframe' ),
				'tab'           => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'category_color',
			[
				'label'         => esc_html__( 'Color', 'proframe' ),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .slides-overlay .slides-category' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'category_typography',
				'selector'      => '{{WRAPPER}} .slides-overlay .slides-category',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slides_title_color',
			[
				'label'         => esc_html__( 'Title', 'proframe' ),
				'tab'           => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'         => esc_html__( 'Title', 'proframe' ),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .slides-overlay .slides-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_hover_color',
			[
				'label'         => esc_html__( 'Title: Hover', 'proframe' ),
				'type'          => Controls_Manager::COLOR,
				'selectors'     => [
					'{{WRAPPER}} .slides-overlay .slides-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'          => 'title_typography',
				'selector'      => '{{WRAPPER}} .slides-overlay .slides-title',
				'scheme'        => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slides_button_color',
			[
				'label'         => esc_html__( 'Button', 'proframe' ),
				'tab'           => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'tabs_button_color' );

		$this->start_controls_tab(
			'tab_button_normal',
			[
				'label'         => esc_html__( 'Normal', 'proframe' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'         => esc_html__( 'Text Color', 'proframe' ),
				'type'          => Controls_Manager::COLOR,
				'default'       => '',
				'selectors'     => [
					'{{WRAPPER}} .slides-overlay .slides-button a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'         => esc_html__( 'Background Color', 'proframe' ),
				'type'          => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .slides-overlay .slides-button a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			[
				'label'          => esc_html__( 'Hover', 'proframe' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label'          => esc_html__( 'Text Color', 'proframe' ),
				'type'           => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .slides-overlay .slides-button a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_hover_color',
			[
				'label'          => esc_html__( 'Background Color', 'proframe' ),
				'type'           => Controls_Manager::COLOR,
				'selectors'      => [
					'{{WRAPPER}} .slides-overlay .slides-button a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'button_border_radius',
			[
				'label'          => esc_html__( 'Border Radius', 'proframe' ),
				'type'           => Controls_Manager::DIMENSIONS,
				'size_units'     => [ 'px', '%' ],
				'selectors'      => [
					'{{WRAPPER}} .slides-overlay .slides-button a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();

		// Vars
		$posts_per_page = $settings['count'];
		$post_type      = $settings['post_type'];
		$order 			= $settings['order'];
		$orderby  		= $settings['orderby'];

		$args = array(
			'posts_per_page'    => $posts_per_page,
			'post_type'         => $post_type,
			'order'             => $order,
			'orderby'           => $orderby
		);

		// Build the WordPress query
		$portfolio = new \WP_Query( $args );

		// Output posts
		if ( $portfolio->have_posts() ) :

			// Vars
			$title          = $settings['title'];
			$category       = $settings['category'];
			$view_more      = $settings['view_more'];
			$view_more_text = $settings['view_more_text'];

			// Wrapper classes
			$wrap_classes = array( 'proframe-slides', 'proframe-items', 'owl-carousel', 'owl-theme' );
			$wrap_classes = implode( ' ', $wrap_classes );
			?>

			<div class="<?php echo esc_attr( $wrap_classes ); ?>">

				<?php

				// Start loop
				while ( $portfolio->have_posts() ) : $portfolio->the_post(); ?>

					<article <?php post_class(); ?>>

						<div class="thumbnail">

							<?php
								the_post_thumbnail( 'proframe-post-large', array(
									'alt' => the_title_attribute( array(
										'echo' => false,
									) ),
								) );
							?>

						</div>

						<div class="slides-overlay">
							<div class="overlay-content">

								<?php
									$terms = get_the_terms( get_the_ID(), 'portfolio-type' );
									if ( 'show' === $category && $terms && !is_wp_error( $terms ) ) :

									$cat = array();
									foreach ( $terms as $term ) {
										$cat[] = $term->name;
									}
									$cats = join( ", ", $cat );
								?>
									<span class="slides-category"><?php echo esc_html( $cats ); ?></span>
								<?php endif;?>

								<?php if ( 'show' === $title ) : ?>
									<?php the_title( sprintf( '<h2 class="slides-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
								<?php endif; ?>

								<?php if ( 'show' === $view_more ) : ?>
									<span class="slides-button">
										<a href="<?php the_permalink(); ?>"><?php echo esc_html( $view_more_text ); ?></a>
									</span>
								<?php endif; ?>

							</div>
						</div>

					</article>

				<?php
				// End entry loop
				endwhile; ?>

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

Plugin::instance()->widgets_manager->register_widget_type( new Proframe_Widget_Slides() );
