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
global $wpshop_social;

$is_show_social_js = $wpshop_core->get_option( 'structure_social_js' );

$social_profiles = apply_filters( THEME_SLUG . '_social_share_links', array(
    'facebook', 'vkontakte', 'twitter', 'odnoklassniki', 'telegram',
    'youtube', 'instagram', 'tiktok', 'linkedin', 'whatsapp', 'viber', 'pinterest', 'yandexzen',
) );

foreach ( $social_profiles as $social_profile ) {
    if ( $wpshop_core->get_option( 'social_' . $social_profile ) ) {
        $social_profile_links[$social_profile] = $wpshop_core->get_option( 'social_' . $social_profile );
    }
}

if ( ! empty( $social_profile_links ) ) {
?>

<div class="social-links">
    <div class="social-buttons social-buttons--square social-buttons--circle">

    <?php
        $wpshop_social->social_profiles( $social_profile_links, $is_show_social_js );
    ?>

    </div>
</div>

<?php } ?>