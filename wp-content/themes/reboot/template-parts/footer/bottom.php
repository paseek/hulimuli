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

?>

<div class="footer-bottom">
    <div class="footer-info">
        <?php
        $footer_copyright = $wpshop_core->get_option( 'footer_copyright' );
        $footer_copyright = str_replace( '%year%', date('Y'), $footer_copyright );
        echo $footer_copyright;
        ?>
    </div>

    <?php
    $footer_counters = $wpshop_core->get_option( 'footer_counters' );
    if ( ! empty( $footer_counters ) ) echo '<div class="footer-counters">' . $footer_counters . '</div>';
    ?>
</div>