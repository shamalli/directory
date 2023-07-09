<div class="hero-wrapper">
	<div class="hero">
		<div class="hero-inner">
			<?php $title = get_theme_mod( 'listing_manager_front_hero_images_title', null ); ?>
			<?php if ( ! empty( $title ) ) : ?>
				<h1><?php echo esc_html( $title ); ?></h1>
			<?php endif; ?>

			<?php $description = get_theme_mod( 'listing_manager_front_hero_images_description', null ); ?>
			<?php if ( ! empty( $description ) ) : ?>
				<p><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>

			<div class="buttons">
				<?php $primary_button_link = get_theme_mod( 'listing_manager_front_hero_images_primary_button_link', null ); ?>
				<?php $primary_button_text = get_theme_mod( 'listing_manager_front_hero_images_primary_button_text', null ); ?>

				<?php if ( ! empty( $primary_button_link ) && ! empty( $primary_button_text ) ) : ?>
					<a href="<?php echo esc_attr( $primary_button_link ); ?>" class="button button-primary">
						<?php echo esc_html( $primary_button_text ); ?>
					</a><!-- /.button -->
				<?php endif; ?>

				<?php $secondary_button_link = get_theme_mod( 'listing_manager_front_hero_images_secondary_button_link', null ); ?>
				<?php $secondary_button_text = get_theme_mod( 'listing_manager_front_hero_images_secondary_button_text', null ); ?>

				<?php if ( ! empty( $secondary_button_link ) && ! empty( $secondary_button_text ) ) : ?>
					<a href="<?php echo esc_attr( $secondary_button_link ); ?>" class="button button-white">
						<?php echo esc_html( $secondary_button_text ); ?>

						<?php $secondary_button_description = get_theme_mod( 'listing_manager_front_hero_images_secondary_button_description', null ); ?>
						<?php if ( ! empty( $secondary_button_description ) ) : ?>
							<span class="description">
								<?php echo esc_html( $secondary_button_description ); ?>
							</span>
						<?php endif; ?>
					</a><!-- /.button -->
				<?php endif; ?>
			</div><!-- /.buttons -->
		</div><!-- /.hero-inner -->

		<?php $image_center = get_theme_mod( 'listing_manager_front_hero_images_image_1', null ); ?>
		<?php if ( ! empty( $image_center ) ) : ?>
			<div class="hero-image center" style="background-image: url('<?php echo esc_attr( $image_center ); ?>')"></div><!-- /.hero-image -->
		<?php endif; ?>

		<?php $image_left = get_theme_mod( 'listing_manager_front_hero_images_image_2', null ); ?>
		<?php if ( ! empty( $image_left ) ) : ?>
			<div class="hero-image left" style="background-image: url('<?php echo esc_attr( $image_left ); ?>')"></div><!-- /.hero-image -->
		<?php endif; ?>

		<?php $image_right = get_theme_mod( 'listing_manager_front_hero_images_image_3', null ); ?>
		<?php if ( ! empty( $image_right ) ) : ?>
			<div class="hero-image right" style="background-image: url('<?php echo esc_attr( $image_right ); ?>')"></div><!-- /.hero-image -->
		<?php endif; ?>
	</div><!-- /.hero -->
</div><!-- /.hero-wrapper -->