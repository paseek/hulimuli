<?php
/**
 * YARPP Template: WPShop YARPP Template
 * Description: WPShop YARPP Template
 * Author: WPShop
 */

global $class_advertising;
?>

<?php if ( have_posts() ): ?>

<!-- yarpp -->
<div class="related-posts fixed">

    <?php echo $class_advertising->show_ad( 'before_related' ) ?>

    <div class="related-posts__header"><?php echo apply_filters( THEME_SLUG . '_related_title', __( 'You may also like', THEME_TEXTDOMAIN ) ) ?></div>

    <div class="post-cards post-cards--vertical">
        <?php
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/post-card/related' );
            endwhile;
        ?>
    </div>

    <?php echo $class_advertising->show_ad( 'after_related' ) ?>

</div>

<?php else : ?>
<!-- no YARPP related -->
<?php endif; ?>