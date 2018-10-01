<?php

namespace LocalSocialCash;

class BizReport{
    
    public function returnReportHTML(){
        
        $output = "";
        $blogusers = get_users();
        // Array of WP_User objects.
        $output = "<table>";
        $output = $output . "<tr><td>ID</td><td>First Name</td><td>Last Name</td><td>Phone</td><td>Email</td><td>Facebook</td></tr>";
        foreach ( $blogusers as $user ) {
            $ID = $user->ID;
            $output = $output . "<tr>";
            $output = $output . "<td>$ID</td>";
            $output = $output . "<td>" . get_user_meta($ID, 'first_name', TRUE) . "</td>"; 
            $output = $output . "<td>" . get_user_meta($ID, 'last_name', TRUE) . "</td>"; 
            $output = $output . "<td>" . get_user_meta($ID, 'phone', TRUE) . "</td>";
            $email = $user->user_email;
            $output = $output . "<td>" . $email . "</td>";
            $output = $output . "<td>" . get_user_meta($ID, 'fbName', TRUE) . "</td>"; 
            $output = $output . "</tr>";
        }
        $output = $output . "</table>";
        return $output;
    }
}