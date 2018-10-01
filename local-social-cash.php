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

