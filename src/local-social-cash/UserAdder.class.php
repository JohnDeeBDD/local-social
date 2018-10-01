<?php

namespace LocalSocialCash;

class UserAdder{
    
    public function addUser(){
        $email = $_POST['email'];
        if (!( email_exists($email )) ) {
            $ID = $this->createAndSignonUser($email, "subscriber");
        }else{
            //$this->updateUserData($UserID);
            $user = get_user_by( 'email', $email );
            $this->updateUserData($user->ID);
        }
    }
    
    public function updateUserData($UserID){
        update_user_meta( $UserID, 'first_name', $_POST['firstName'] );
        update_user_meta( $UserID, 'last_name', $_POST['lastName'] );
        update_user_meta( $UserID, 'fbName', $_POST['fbName'] );
        update_user_meta( $UserID, 'state', $_POST['state'] );
        update_user_meta( $UserID, 'phone', $_POST['phone'] );
        update_user_meta( $UserID, 'yeson3', TRUE );
    }
    
    public function createAndSignonUser($email, $userRole = "subscriber"){
        global $wpdb;
        $password = wp_generate_password();
        $user_id = wp_create_user( $email, $password, $email );
        $user = new \WP_User( $user_id );
        //wp_set_auth_cookie( $user->ID, TRUE );
        //either 'administrator', 'subscriber', 'editor', 'author', 'contributor':
        $user->set_role( $userRole );
        $first_name = $this->trimDomainFromEmail($email);
        $user_id = wp_update_user( array( 'ID' => $user_id, 'first_name' => $first_name) );
        $creds = array();
        $creds['user_login'] = $email;
        $creds['user_password'] = $password;
        $creds['remember'] = true;
        //$user = wp_signon( $creds, true );
        $user = get_user_by( 'email', $email );
        $UserID = $user->ID;
        $this->updateUserData($UserID);
        $trimmedEmail = $this->trimDomainFromEmail($email);
        update_user_meta( $UserID, 'nickname', $trimmedEmail);
        $wpdb->query("UPDATE $wpdb->users SET display_name = '$trimmedEmail' WHERE ID = $UserID");
        return $UserID;
    }
    
    
    
    //This function returns the first part of an email. i.e. "jiminac@gmail.com" is trimmed to "jiminac" :
    public function trimDomainFromEmail($email){
        $trimmed = '';
        $arr1 = str_split($email);
        foreach ($arr1 as $l){
            if ($l == "@"){break;}
            $trimmed = $trimmed . $l;
        }
        return $trimmed;
    }
    
}