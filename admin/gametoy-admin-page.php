<?php

// جلوگیری از دسترسی مستقیم
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// تابع نمایش صفحه تنظیمات افزونه
function gametoy_admin_page() {
    ?>
    <div class="wrap">
        <h1>تنظیمات GameToy</h1>
        <form method="post" action="options.php">
            <?php
            // تنظیمات و فیلدهای فرم را اینجا اضافه کنید
            settings_fields('gametoy_settings_group');
            do_settings_sections('gametoy');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
?>