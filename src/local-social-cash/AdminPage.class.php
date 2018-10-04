<?php

namespace LocalSocialCash;

class AdminPage{
    
    public function echoAdminPage(){
        
        $output = "";
        $blogusers = get_users();
        // Array of WP_User objects.
        $numUsers = 0;
        foreach ( $blogusers as $user ) {
            $ID = $user->ID;
            $email = $user->user_email;
            $output . $output = "$email; " . get_user_meta($ID, 'first_name', TRUE) . ";" . get_user_meta($ID, 'last_name', TRUE) . "<br />";
            $numUsers = $numUsers + 1;
        }
        echo $output;
    }
}