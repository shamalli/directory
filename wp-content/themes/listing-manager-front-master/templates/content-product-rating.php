<div class="product-rating">
    <?php for ( $i = 1; $i <= 5; $i++ ) : ?>
        <?php if ( $i <= $rating ) : ?>
            <i class="fa fa-star"></i>
        <?php else: ?>
            <i class="fa fa-star-o"></i>
        <?php endif; ?>
    <?php endfor; ?>
</div><!-- /.product-rating -->
