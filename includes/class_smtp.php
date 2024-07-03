<?php
// تنظیمات SMTP
add_action('phpmailer_init', function($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'mail.cigiftcard.com';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 587;
    $phpmailer->Username = 'shop@cigiftcard.com';
    $phpmailer->Password = 'Aa1707489@';
    $phpmailer->SMTPSecure = 'tls';
    $phpmailer->From = 'shop@cigiftcard.com';
    $phpmailer->FromName = 'گیف کارد';
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