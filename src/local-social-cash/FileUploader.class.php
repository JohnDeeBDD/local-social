<?php
namespace LocalSocialCash; 

class FileUploader{    
    public function returnReportHTML(){
        if(is_user_logged_in()){ 
            $output = "";
          $user =  wp_get_current_user();
          global $post; 
            $output = $output ."User ID : ". $user->ID; 
            $output = $output ."<br> "; 
            $output = $output ."Post ID : ". $post->ID;  


        return $output;
    
}
    else 
        $url = get_home_url();
        wp_redirect( $url );
exit;
    }
}
