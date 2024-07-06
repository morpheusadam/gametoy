<?php
// تنظیمات SMTP با استفاده از OAuth2
add_action('phpmailer_init', function($phpmailer) {
    ini_set('display_errors', 1); // Corrected 'display_error' to 'display_errors'
    error_reporting(E_ALL);
    $from = "sender@cigiftcard.com";
    $headers = "From: " . $from . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
});

// قالب ایمیل رسمی و شرکتی و فارسی
function create_persian_email_template($subject, $body) {
    $template = "
    <html>
    <head>
        <style>
            body { font-family: 'Tahoma', sans-serif; direction: rtl; }
            .header { background-color: #f2f2f2; padding: 10px; text-align: center; }
            .content { margin: 20px; }
            .footer { background-color: #f2f2f2; padding: 10px; text-align: center; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h1>شرکت گیف کارد</h1>
        </div>
        <div class='content'>
            $body
        </div>
        <div class='footer'>
            <p>این ایمیل به صورت خودکار ارسال شده است. لطفاً به آن پاسخ ندهید.</p>
        </div>
    </body>
    </html>
    ";
    return array('subject' => $subject, 'body' => $template);
}
?>