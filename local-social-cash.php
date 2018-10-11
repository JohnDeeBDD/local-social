<?php
/*
 Plugin Name: Local Social Cash
 Plugin URI: https://generalchicken.net/
 Description: 
 Version: 1.0
 Author: John Dee
 Author URI: https://generalchicken.net
 */
namespace LocalSocialCash;
require_once (plugin_dir_path(__FILE__). 'src/local-social-cash/autoloader.php');
add_shortcode('biz-report', array(new BizReport, 'returnReportHTML'));
if (isset($_POST['localSocialForm'])){
    add_action('init', array(new UserAdder, 'addUser'));
}
add_action(
    'admin_menu',
    function(){
        add_menu_page(
            'EMAILS',
            'EMAILS',
            'manage_options',
            'EMAILS',
            array(new AdminPage, 'echoAdminPage')
            );
    }
);
add_shortcode('fileuploader', array(new FileUploader, 'returnReportHTML'));
if (isset($_POST['file-from-form'])){
     add_action('init', array(new FileUploader, 'listenToFormSubmission'));
}

if (isset($_POST['localSocialForm'])){
    $to = 'johndeebdd@gmail.com';
    $subject = 'Form Submission';
    $body = "First Name: " . $_POST['firstName'] . "\n\r";
    $body = $body . "Last Name: " . $_POST['lastName'] . "\n\r";
    $body = $body . "Email: " . $_POST['email'] . "\n\r";
    $body = $body . "Phone: " . $_POST['phone'] . "\n\r";
    $body = $body . "Facebook: " . $_POST['fbName'] . "\n\r";
    $body = $body . "State: " . $_POST['state'] . "\n\r";
    \wp_mail( $to, $subject, $body, $headers );
}

if (isset($_POST['yappa-name'])){
    $to = 'a.mayfield18@gmail.com';
    $subject = 'YAPPA INTEREST';
    $body = "Name: " . $_POST['yappa-name'] . "\n\r";
    $body = $body . "Email: " . $_POST['yappa-email'] . "\n\r";
    $body = $body . "Phone: " . $_POST['yappa-phone'] . "\n\r";
    $body = $body . "Site URL: " . $_POST['yappa-site-url'] . "\n\r";
    \wp_mail( $to, $subject, $body, $headers );
}