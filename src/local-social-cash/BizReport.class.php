<?php

namespace LocalSocialCash;

class BizReport{
    
    public function returnReportHTML(){
        
        $output = "";
        $blogusers = get_users();
        // Array of WP_User objects.
        $output = "
<style>
table {
    width: 100%;
}

th {
    height: 50px;
}
table, th, td {
   border: 1px solid black;
}

</style>
<table>";
        $output = $output . "<tr><td><strong>First Name</strong></td><td><strong>Last Name</strong></td><td><strong>Phone</strong></td><td><strong>Email</strong></td><td><strong>Facebook</strong></td></tr>";
        $numUsers = 0;
        foreach ( $blogusers as $user ) {
            $ID = $user->ID;
            $output = $output . "<tr>";
            $output = $output . "<td>" . get_user_meta($ID, 'first_name', TRUE) . "</td>"; 
            $output = $output . "<td>" . get_user_meta($ID, 'last_name', TRUE) . "</td>"; 
            $output = $output . "<td>" . get_user_meta($ID, 'phone', TRUE) . "</td>";
            $email = $user->user_email;
            $output = $output . "<td>" . $email . "</td>";
            $output = $output . "<td>" . get_user_meta($ID, 'fbName', TRUE) . "</td>"; 
            $output = $output . "</tr>";
            $numUsers = $numUsers + 1;
        }
        $output = $output . "</table><h2>Number of Users: $numUsers</h2>";
        return $output;
    }
}