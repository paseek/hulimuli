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
global $class_advertising;

$is_show_arrow     = $wpshop_core->get_option( 'arrow_display' );
$is_show_arrow_mob = ( $wpshop_core->get_option( 'arrow_mob_display' ) ) ? ' data-mob="on"' : '';

?>

    </div><!--.site-content-inner-->

    <?php echo $class_advertising->show_ad( 'after_site_content' ) ?>

</div><!--.site-content-->

    <?php do_action( THEME_SLUG . '_after_site_content' ) ?>

    <?php
    if ( $wpshop_core->is_show_element( 'footer' ) ) {
        get_template_part( 'template-parts/footer/footer' );
    } ?>

    <?php if ( $is_show_arrow ) { ?>
        <button type="button" class="scrolltop js-scrolltop"<?php echo $is_show_arrow_mob ?>></button>
    <?php } ?>

</div><!-- #page -->

<?php wp_footer(); ?>
<?php $wpshop_core->the_option( 'code_body' ) ?>

<?php do_action( THEME_SLUG . '_before_body' ) ?>

<?php
$slider_count_mod = $wpshop_core->get_option( 'slider_count' );

$slider_per_view = 1;

if ( $wpshop_core->get_option( 'slider_type' ) == 'three' ) {
    $slider_per_view = 3;
}

if ( $wpshop_core->get_option( 'slider_type' ) == 'thumbnails' ) {
    $slider_per_view = 1;
}

if ( ( is_front_page() || is_home() ) && $slider_count_mod != 0 ) { ?>
    <!-- Initialize Swiper -->
    <script>
        <?php if ( $wpshop_core->get_option( 'slider_type' ) == 'thumbnails' ) { ?>

        var wpshopSwiperThumbs = new Swiper('.js-swiper-home-thumbnails', {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            loopedSlides: 5, //looped slides should be the same
            watchSlidesVisibility: true,
            watchSlidesProgress: true,
            breakpoints: {
                1024: {
                    slidesPerView: 4,
                },
                900: {
                    slidesPerView: 3,
                },
                760: {
                    slidesPerView: 2,
                },
                600: {
                    slidesPerView: 1,
                },
            },
        });

        <?php } ?>

        var wpshopSwiper = new Swiper('.js-swiper-home', {
	        <?php if ( $wpshop_core->get_option( 'slider_type' ) != 'thumbnails' ) { ?>
            slidesPerView: <?php echo $slider_per_view ?>,
	        <?php } ?>
            <?php if ( $wpshop_core->get_option( 'slider_type' ) == 'three' ) { ?>
            breakpoints: {
                1201: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                300: {
                    slidesPerView: 1,
                }
            },
            <?php } ?>
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            <?php if ( is_numeric( $wpshop_core->get_option('slider_autoplay') ) && $wpshop_core->get_option('slider_autoplay') > 0 ) { ?>
            autoplay: {
                delay: <?php $wpshop_core->the_option('slider_autoplay') ?>,
                disableOnInteraction: true,
            },
            <?php } ?>
	        <?php if ( $wpshop_core->get_option( 'slider_type' ) == 'thumbnails' ) { ?>
            thumbs: {
                swiper: wpshopSwiperThumbs,
            },
            loopedSlides: 5, //looped slides should be the same
            <?php } ?>
        });
    </script>
<?php } ?>

</body>
</html>
