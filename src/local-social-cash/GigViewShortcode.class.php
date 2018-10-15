<?php

namespace LocalSocialCash;

class GigViewShortcode{
    
    public function returnShortcode(){
        if(!(is_user_logged_in())){
            return ("You must be logged in to view this page.");
        }
        
        
        $output = "HELLO WORLD";
        return $output;
        
    }
    
}