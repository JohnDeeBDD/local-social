<?php

namespace LocalSocialCash;

class GigViewShortcode{
    
    public function returnShortcode(){
        
        if(!(is_user_logged_in())){
            return ("You must be logged in to view this page.");
        }
        
        
        /*$output = "";
         $user =  wp_get_current_user();
         global $post;
         $output = $output ."User ID : ". $user->ID;
         $output = $output ."<br> ";
         $output = $output ."Post ID : ". $post->ID;
         return $output;
         */
        $args = array('post_type' => 'task');
        // The Query
        $the_query = new \WP_Query( $args );
        
        $output = '<ul>';
        // The Loop
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $ID = get_the_ID();
                $user =  wp_get_current_user();
                $userID = $user->ID;
                //var_dump($userID); die();
                global $post;$backup=$post;
                if(!($this->boolUserHasProofForTask($userID, $ID))){
                    $post=$backup;
                    $output = $output . '<li><a href = "' . get_the_permalink() . '"/>' . get_the_title(). '</a></li>';
                }
            }
            $output = $output . '</ul>';
            
            //wp_reset_postdata();
        } else {
            $output = "You're all done! you will receive payment within 24 hours. Thank you!";
        }
        
        return $output;
        
    }
    
    public function boolUserHasProofForTask($userID, $taskID){
        $boolReturn = FALSE;
        $args = array('post_type' => 'proof', 'post_author' => $userID);
        $the_query = new \WP_Query( $args );
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $ID = get_the_ID();
                //echo("THE ID IS: $ID <br />");
                $proofMetaReference = get_post_meta( $ID, 'task-ID', true );
                //echo("THE meta IS: $proofMetaReference <br />");
                if($proofMetaReference == $taskID){
                    $boolReturn = TRUE;
                }
            }
            
            
            //wp_reset_postdata();
        } else {
            // no posts found
        }
        return $boolReturn;
    }
    
}