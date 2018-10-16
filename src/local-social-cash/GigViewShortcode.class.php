<?php

namespace LocalSocialCash;

class GigViewShortcode{
    
    public function returnShortcode(){
        
        if(!(is_user_logged_in())){
            return ("You must be logged in to view this page. Please <a href = '/wp-login.php'>click here to login</a>.");
        }
        
        
        /*$output = "";
         $user =  wp_get_current_user();
         global $post;
         $output = $output ."User ID : ". $user->ID;
         $output = $output ."<br> ";
         $output = $output ."Post ID : ". $post->ID;
         return $output;
         */
        $args = array('post_type' => 'task', 'posts_per_page' => -1);
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
                $user_info = get_userdata($userID);
                $user_email = $user_info->user_email;
                global $post;$backup=$post;
                if(!($this->boolUserHasProofForTask($userID, $ID))){
                    $post=$backup;
                    $output = $output . '<li><a href = "' . get_the_permalink() . '" target = "_blank" />' . get_the_title(). '</a></li>';
                    $output = $output . $this->returnCommentRoll($user_email, $ID);
                }
            }
            $output = $output . '</ul>';
            
            //wp_reset_postdata();
        } else {
            $output = "You're all done! you will receive payment within 24 hours. Thank you!";
        }
        
        return $output;
        
    } 
    
    public function returnCommentRoll($userEmail, $taskID){
        $output = "";
        $args = array(
            'author_email' => $userEmail,
            'include_unapproved' => TRUE,
            'post_id' => $taskID,
        );
        
        // The Query
        $comments_query = new \WP_Comment_Query;
        $comments = $comments_query->query( $args );
        $output = "";
        // Comment Loop
        if ( $comments ) {
            foreach ( $comments as $comment ) {
                $output = $output . '<p>' . $comment->comment_content . '</p>';
            }
        } else {
            $output = $output . 'No results found.';
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