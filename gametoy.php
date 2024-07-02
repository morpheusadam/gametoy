<?php
/*
Plugin Name: GameToy
Description: افزونه برای برقراری رابطه بین WooCommerce و یک سایت خارجی.
Version: 1.0
Author: نام شما
*/

// جلوگیری از دسترسی مستقیم
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// تعریف ثابت‌ها
define( 'GAMETOY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// بارگذاری فایل‌های مورد نیاز
require_once GAMETOY_PLUGIN_DIR . 'includes/class-gametoy-api.php';
require_once GAMETOY_PLUGIN_DIR . 'includes/class-gametoy-sync.php';
require_once GAMETOY_PLUGIN_DIR . 'admin/gametoy-admin-page.php';

// فعال‌سازی افزونه
function gametoy_activate() {
    // کدهای فعال‌سازی
}
register_activation_hook( __FILE__, 'gametoy_activate' );

// غیرفعال‌سازی افزونه
function gametoy_deactivate() {
    // کدهای غیرفعال‌سازی
}
register_deactivation_hook( __FILE__, 'gametoy_deactivate' );

// افزودن آیتم به منوی داشبورد
function gametoy_add_admin_menu() {
    add_menu_page(
        'GameToy Settings', // عنوان صفحه
        'GameToy',          // عنوان منو
        'manage_options',   // قابلیت دسترسی
        'gametoy',          // اسلاگ منو
        'gametoy_admin_page', // تابع نمایش صفحه
        'dashicons-admin-generic', // آیکون منو
        6                   // موقعیت منو
    );
}
add_action('admin_menu', 'gametoy_add_admin_menu');

// نمایش پیام در داشبورد وردپرس
function gametoy_admin_notice() {
    ?>
    <div class="notice notice-success is-dismissible">
        <p>افزونه GameToy با موفقیت فعال شد!</p>
    </div>
    <?php
}
add_action('admin_notices', 'gametoy_admin_notice');
?>