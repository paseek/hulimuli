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

$footer_widgets = $wpshop_core->get_option( 'footer_widgets' );
if ( $footer_widgets > 5 ) $footer_widgets = 5;

if ( $footer_widgets > 0 ) {

    echo '<div class="footer-widgets footer-widgets-'. $footer_widgets .'">';

    for ( $n = 1; $n <= $footer_widgets; $n++ ) {

        echo '<div class="footer-widget">';
        dynamic_sidebar( 'footer-widget-' . $n );
        echo '</div>';

    }

    echo '</div>';
}
