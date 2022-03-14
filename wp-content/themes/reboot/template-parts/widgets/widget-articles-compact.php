<?php
/**
 * ****************************************************************************
 *
 *   DON'T EDIT THIS FILE
 *   After update you will lose all changes. Use child theme
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   После обновления Вы потереяете все изменения. Используйте дочернюю тему
 *
 *   https://support.wpshop.ru/docs/general/child-themes/
 *
 * *****************************************************************************
 *
 * @package reboot
 */

global $wpshop_template;
global $wpshop_helper;
global $single_post;
global $hide_category;
global $hide_meta;
global $link_target;

?>

<article class="post-card post-card--small">
    <?php $thumb = get_the_post_thumbnail( $single_post->ID, apply_filters( THEME_SLUG . '_widget_article_compact_thumbnail', 'reboot_square' ) ); if ( ! empty( $thumb ) ) : ?>
        <div class="post-card__thumbnail">
            <a href="<?php echo get_permalink( $single_post->ID ) ?>"<?php echo ( $link_target == true ) ? ' target="_blank"' : ''; ?>>
                <?php echo $thumb ?>
            </a>
        </div>
    <?php endif ?>

    <div class="post-card__body">
        <?php
        if ( ! $hide_category ) :
            echo $wpshop_template->get_category( [ 'post' => $single_post->ID, 'classes' => 'post-card__category', 'micro' => false, 'link' => false ] );
        endif;
        ?>

        <div class="post-card__title"><a href="<?php echo get_permalink( $single_post->ID ) ?>"><?php echo get_the_title( $single_post->ID ) ?></a></div>

        <?php if ( ! $hide_meta ) : ?>
            <div class="post-card__meta">
                <span class="post-card__comments"><?php echo get_comments_number( $single_post->ID ) ?></span>
                <?php if ( $wpshop_template->get_views( $single_post->ID ) > 0 ) {
                    echo '<span class="post-card__views">' . $wpshop_helper->rounded_number( $wpshop_template->get_views( $single_post->ID ) ) . '</span>';
                } ?>
            </div>
        <?php endif ?>
    </div>
</article>