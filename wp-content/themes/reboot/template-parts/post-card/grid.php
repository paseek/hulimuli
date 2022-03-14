<?php
/**
 * ****************************************************************************
 *
 *   НЕ РЕДАКТИРУЙТЕ ЭТОТ ФАЙЛ
 *   DON'T EDIT THIS FILE
 *
 *   После обновления Вы потереяете все изменения. Используйте дочернюю тему
 *   After update you will lose all changes. Use child theme
 *
 *   https://support.wpshop.ru/docs/general/child-themes/
 *
 * *****************************************************************************
 *
 * @package reboot
 */

global $wpshop_core;
global $wpshop_helper;
global $wpshop_template;

$post_card_type = 'grid';
$post_card_thumb_size = apply_filters( THEME_SLUG . '_post_card_' . $post_card_type . '_thumbnail_size', THEME_SLUG . '_small' );
$section_options = ( isset( $section_options ) ) ? $section_options : [];


/**
 * order
 */
$post_card_order = $wpshop_core->get_option( 'post_card_' . $post_card_type . '_order' );
$post_card_order = explode( ',', $post_card_order );

$post_card_order_meta = $wpshop_core->get_option( 'post_card_' . $post_card_type . '_order_meta' );
$post_card_order_meta = explode( ',', $post_card_order_meta );


/**
 * post card class
 */
$post_card = new Wpshop\PostCard\PostCard();
$post_card->set_order( array_merge( $post_card_order, $post_card_order_meta ) );
$post_card->set_section_options( $section_options );


/**
 * default
 */
$post_card_attributes = [ 'itemscope', 'itemtype="http://schema.org/BlogPosting"'  ];
$post_card_classes    = [ 'post-card--' . $post_card_type ];
$description_length   = (int) $wpshop_core->get_option( 'post_card_' . $post_card_type . '_excerpt_length' );


/**
 * prepare data
 */
$thumb = get_the_post_thumbnail( $post->ID, $post_card_thumb_size, array( 'itemprop' => 'image' ) );
if ( empty( $thumb ) ) {
	$post_card_classes[] = 'post-card--thumbnail-no';
}
if ( ! $post_card->is_show_element( 'thumbnail' ) ) {
	$post_card_classes[] = 'post-card--thumbnail-no';
}
$animation_type = $wpshop_core->get_option( 'post_card_' . $post_card_type . '_animation_type' );
if ( ! empty( $animation_type ) ) {
	$post_card_classes[] = 'w-animate';
	$post_card_attributes[] = 'data-animate-style="' . $animation_type . '"';
}

?>

<div class="post-card <?php echo implode( ' ', $post_card_classes ) ?>" <?php echo implode( ' ', $post_card_attributes ) ?>>
	<?php if ( ! empty( $thumb ) && $post_card->is_show_element( 'thumbnail' ) ) : ?>
        <a href="<?php the_permalink() ?>">
            <div class="post-card__thumbnail">
                <?php echo $thumb ?>

                <?php if ( 'post' === get_post_type() && $post_card->is_show_element( 'category' ) ) { ?>
                    <?php echo $wpshop_template->get_category( [ 'classes' => 'post-card__category', 'link' => false ] ) ?>
                <?php } ?>
            </div>
        </a>
	<?php endif; ?>

    <div class="post-card__body">

	    <?php
	    foreach ( $post_card_order as $order ) {

		    if ( 'post' === get_post_type() && $order == 'category' && $post_card->is_show_element( 'category' ) ) {
			    if ( empty( $thumb ) || ! $post_card->is_show_element( 'thumbnail' ) ) {
				    echo '<span class="post-card__category" itemprop="articleSection">';
				    echo $wpshop_template->get_category( [ 'link' => false ] );
				    echo '</span>';
			    }
		    }

		    if ( $order == 'title' && $post_card->is_show_element( 'title' ) ) {
			    echo '<div class="post-card__title" itemprop="name">';
			    echo '<span itemprop="headline">';
			    echo '<a href="' . get_the_permalink() . '">' . get_the_title() . '</a>';
			    echo '</span>';
			    echo '</div>';
		    }

		    if ( $order == 'excerpt' && $post_card->is_show_element( 'excerpt' ) ) {
			    echo '<div class="post-card__description" itemprop="articleBody">';
                $excerpt = get_the_excerpt();
                if ( apply_filters( THEME_SLUG . '_post_card_' . $post_card_type . '_excerpt_strip_tags', true ) ) {
                    $excerpt = strip_tags( $excerpt );
                }
                echo $wpshop_helper->substring_by_word( $excerpt, $description_length );
			    echo '</div>';
		    }

		    if ( 'post' === get_post_type() && $order == 'meta' ) {
			    if (
                    $post_card->is_show_element( 'date' ) ||
				    $post_card->is_show_element( 'comments_number' ) ||
				    $post_card->is_show_element( 'views' ) ||
				    //$post_card->is_show_element( 'likes' ) ||
				    $post_card->is_show_element( 'author' )
			    ) {
				    echo '<div class="post-card__meta">';

				    foreach ( $post_card_order_meta as $meta_order ) {

					    if ( $meta_order == 'date' && $post_card->is_show_element( 'date' ) ) {
						    echo '<span class="post-card__date">';
						    echo '<time itemprop="datePublished" datetime="' . get_the_time( 'Y-m-d' ) . '">';
						    echo get_the_date();
						    echo '</time>';
						    echo '</span>';
					    }

					    if ( $meta_order == 'comments_number' && $post_card->is_show_element( 'comments_number' ) ) {
						    echo '<span class="post-card__comments">' . get_comments_number() . '</span>';
					    }

					    if ( $meta_order == 'views' && $post_card->is_show_element( 'views' ) ) {
						    echo '<span class="post-card__views">';
						    echo $wpshop_helper->rounded_number( $wpshop_template->get_views() );
						    echo '</span>';
					    }

					    /*if ( $meta_order == 'likes' && $post_card->is_show_element( 'likes' ) ) {
						    echo '<span class="post-card__like">';
						    echo $wpshop_helper->rounded_number( $wpshop_template->get_likes() );
						    echo '</span>';
					    }*/

					    if ( $meta_order == 'author' && $post_card->is_show_element( 'author' ) ) {
						    echo '<span class="post-card__author" itemprop="author">';
						    echo get_the_author();
						    echo '</span>';
					    }

				    }

				    echo '</div>';
			    }
		    }

	    }
	    ?>

    </div>

    <?php if ( ! $post_card->is_show_element( 'excerpt' ) ) { ?>
        <meta itemprop="articleBody" content="<?php echo strip_tags( get_the_excerpt() ) ?>">
    <?php } ?>
    <?php if ( ! $post_card->is_show_element( 'author' ) ) { ?>
        <meta itemprop="author" content="<?php the_author() ?>"/>
    <?php } ?>
    <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink() ?>" content="<?php the_title(); ?>">
    <meta itemprop="dateModified" content="<?php the_modified_time('Y-m-d')?>">
    <?php if ( ! $post_card->is_show_element( 'date' ) ) { ?>
        <meta itemprop="datePublished" content="<?php the_time('c') ?>">
    <?php } ?>
    <?php echo $wpshop_template->get_microdata_publisher() ?>

    <?php do_action( THEME_SLUG . '_post_card_meta' ) ?>
</div>
