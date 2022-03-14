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
global $wpshop_breadcrumbs;

$breadcrumbs_display = $wpshop_core->get_option( 'breadcrumbs_display' );

if ( $breadcrumbs_display ) :

    $breadcrumbs_service = 'self';

    if ( function_exists('yoast_breadcrumb') ) {
        $wpseo_titles = get_option( 'wpseo_titles' );
        if ( $wpseo_titles['breadcrumbs-enable'] ) $breadcrumbs_service = 'yoast';
    }

    if ( $breadcrumbs_service == 'yoast' ) {
        yoast_breadcrumb('<div class="breadcrumb" id="breadcrumbs">','</div>');
    } else {
        echo $wpshop_breadcrumbs->output();
    }

endif;