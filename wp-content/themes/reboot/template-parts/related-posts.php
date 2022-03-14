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
 *   https://docs.wpshop.ru/start/child-themes
 *
 * *****************************************************************************
 *
 * @package reboot
 */

global $wpshop_core;
global $class_advertising;

if ( is_page() ) {
    $related_count_mod = $wpshop_core->get_option( 'structure_page_related' );
} else {
    $related_count_mod = $wpshop_core->get_option( 'structure_single_related' );
}
$related_yarpp_enabled = apply_filters( THEME_SLUG . '_yarpp_enabled', false );


if ( ! empty( $related_count_mod  ) && ! $related_yarpp_enabled ) {

    $related_articles = [];

    $related_post_taxonomy_order    = $wpshop_core->get_option( 'related_post_taxonomy_order' );
    $related_posts_exclude          = $wpshop_core->get_option( 'related_posts_exclude' );
    $related_posts_category_exclude = $wpshop_core->get_option( 'related_posts_category_exclude' );

    if ( ! empty( $related_posts_exclude ) ) {
        $related_posts_exclude = explode( ',', $related_posts_exclude );

        foreach ( $related_posts_exclude as $key => $value ) {
            $post__not_in[] = $related_posts_exclude[$key];
        }
    }

    if ( ! empty( $related_posts_category_exclude ) ) {
        $related_posts_category_exclude = explode( ',', $related_posts_category_exclude );

        foreach ( $related_posts_category_exclude as $key => $value ) {
            $related_posts_category_id_exclude[$key] = '-' . $related_posts_category_exclude[$key];
        }
    } else {
        $related_posts_category_id_exclude = [];
    }

    $related_count = 8;
    if ( is_numeric( $related_count_mod ) && $related_count_mod > -1 ) {
        if ( $related_count_mod > 50 ) $related_count_mod = 50;
        $related_count = $related_count_mod;
    }

    if ( is_single() ) {
        $related_posts_ids = get_post_meta( $post->ID, 'related_posts_ids', true );

        // если указаны посты - набираем их
        if ( ! empty( $related_posts_ids ) ) {

            $related_posts_id_exp = explode( ',', $related_posts_ids );

            if ( is_array( $related_posts_id_exp ) ) {
                $related_posts_ids = array_map( 'trim', $related_posts_id_exp );
            } else {
                $related_posts_ids = [ $related_posts_ids ];
            }

            if ( ! empty( $related_posts_exclude ) ) {
                foreach ( $related_posts_exclude as $key => $value ) {
                    if ( in_array( $related_posts_exclude[$key], $related_posts_ids ) ) unset( $related_posts_ids[$key] );
                }
            }

            if ( ! empty( $related_posts_exclude ) ) {
                $related_articles = get_posts( [
                    'posts_per_page' => $related_count,
                    'post__in'       => $related_posts_ids,
                    'post__not_in'   => [ $post->ID ],
                ] );
            }

        }


        // если не хватило, добираем из категории
        if ( count( $related_articles ) < $related_count ) {

            // сколько осталось постов
            $delta = $related_count - count( $related_articles );

            // убираем текущий пост + уже выведенные
            $post__not_in[] = $post->ID;
            foreach ( $related_articles as $article ) {
                $post__not_in[] = $article->ID;
            }

            if ( $related_post_taxonomy_order == 'categories' ) {
                // подготавливаем категории
                global $post;
                $category_ids = [];
                $categories = get_the_category( $post->ID );
                if ( $categories ) {
                    foreach ( $categories as $_category ) {
                        if ( ! empty( $related_posts_category_exclude ) ) {
                            if ( ! in_array( $_category->term_id, $related_posts_category_exclude ) ) $category_ids[] = $_category->term_id;
                        } else {
                            $category_ids[] = $_category->term_id;
                        }
                    }
                }

                if ( ! empty( $category_ids ) ) {
                    $related_articles_taxonomy = get_posts(
                        apply_filters( 'reboot_related_get_posts_category_args', [
                            'posts_per_page' => $delta,
                            'category__in'   => $category_ids,
                            'post__not_in'   => $post__not_in,
                            ])
                    );
                }
            } else {
                // подготавливаем метки
                global $post;
                $tag_ids = [];
                $tags = get_the_tags( $post->ID );
                if ( $tags ) {
                    foreach ( $tags as $tag ) {
                        $tag_ids[] = $tag->term_taxonomy_id;
                    }
                }

                $related_articles_taxonomy = get_posts(
                    apply_filters( 'reboot_related_get_posts_category_args', [
                            'posts_per_page' => $delta,
                            'category'       => $related_posts_category_id_exclude,
                            'tag__in'        => $tag_ids,
                            'post__not_in'   => $post__not_in,
                    ])
                );
            }

            if ( ! empty( $related_articles_taxonomy ) ) $related_articles = array_merge( $related_articles, $related_articles_taxonomy );


            // если не хватило, добираем рандом
            if ( count( $related_articles ) < $related_count ) {

                // сколько осталось постов
                $delta = $related_count - count( $related_articles );

                // убираем текущий пост + уже выведенные
                $post__not_in[] = $post->ID;
                foreach ( $related_articles as $article ) {
                    $post__not_in[] = $article->ID;
                }

                $related_articles_second = get_posts(
                    apply_filters( 'reboot_related_get_posts_rand_args', [
                        'posts_per_page' => $delta,
                        'category'       => $related_posts_category_id_exclude,
                        'orderby'        => 'rand',
                        'post__not_in'   => $post__not_in,
                    ])
                );


                // если все ок, объединяем
                if ( ! empty( $related_articles_second ) ) $related_articles = array_merge( $related_articles, $related_articles_second );
            }
        }
    } else {
        $related_articles = get_posts(
            apply_filters( 'reboot_related_get_posts_rand_args', [
                'posts_per_page' => $related_count,
                'category'       => $related_posts_category_id_exclude,
                'orderby'        => 'rand',
                'post__not_in'   => $post__not_in,
            ])
        );
    }

    if ( ! empty( $related_articles ) ) {

        echo '<div id="related-posts" class="related-posts fixed">';

            echo $class_advertising->show_ad( 'before_related' );

            echo '<div class="related-posts__header">' . apply_filters( THEME_SLUG . '_related_title', __( 'You may also like', THEME_TEXTDOMAIN ) ) . '</div>';

            echo '<div class="post-cards post-cards--vertical">';
                    foreach ( $related_articles as $post ) {
                        setup_postdata( $post );
                        get_template_part( 'template-parts/post-card/related' );
                    }
                    wp_reset_postdata();
            echo '</div>';

            echo $class_advertising->show_ad( 'after_related' );

        echo '</div>';

    }

} else {

    /**
     * If yarpp enabled
     */
    if ( function_exists( 'related_posts' ) && $related_yarpp_enabled ) {
        related_posts();
    }

}