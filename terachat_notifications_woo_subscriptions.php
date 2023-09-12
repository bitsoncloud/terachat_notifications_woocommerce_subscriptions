<?php
/*
Plugin Name: Terachat Notifications Woocommerce Subscriptions extension.
Plugin URI: https://bitsoncloud.com
Description: Compatibilidad con suscripciones en las Notificaciones de pedido para Woocommerce 
Version: 0.9
Author: Bits On Cloud LLC
Author URI: https://bitsoncloud.com
*/

defined('ABSPATH') or die("Bye bye");
define('TERA_NOTIF_SUBS_RUTA',plugin_dir_path(__FILE__));
define('TERA_NOTIF_SUBS_URL',plugins_url('terachat_notifications_woo_subscriptions'));
define('TERA_NOTIF_SUBS_NOMBRE','Terachat Notifications Woocommerce Subscriptions extension');

include_once TERA_NOTIF_SUBS_RUTA."/funciones.php";





add_action('admin_init', 'tera_notif_subs_check_required_plugins');
function tera_notif_subs_check_required_plugins() {
    $required_plugins = array(
        'terachat_notifications/terachat_notifications.php', 
        'woocommerce-subscriptions/woocommerce-subscriptions.php', 
    );

    foreach ($required_plugins as $plugin) {
        if (!is_plugin_active($plugin)) {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die('Para activar este plugin, necesitas tener activo el Plugin Requerido: ' . $plugin);
        }
    }
}

