<?php

namespace LocalSocialCash;

class ClientReport{
    
    public $count = 0;
    public $actions = 0;
    
    public function listComments($postID, $author_email){
        ?>
        <ol class="commentlist">
        <?php
        //Gather comments for a specific page/post
        $comments = get_comments(array(
        'post_id' => $postID,
        'author_email' => $author_email,
        'include_unapproved' => TRUE,
        ));
        if (count($comment) > 0){$this->countActions($postID, $comments);}
        //Display the list of comments
        wp_list_comments(array(
            'per_page' => -1, //Allow comment pagination
            //'reverse_top_level' => false 
        ), $comments);
        ?>
</ol>
        <?php
        
    }
    
    public function returnShortcode(){
        
        $author_email = $_GET['email'];
        $args = array(
            'post_type' => 'task', 
            'posts_per_page' => -1,
            'post_status' => array('publish', 'pending', 'draft', 'private',)
        );
        // The Query
        $the_query = new \WP_Query( $args );
        
        $output = '<ul>';
        // The Loop
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                $ID = get_the_ID();
                $the_query->the_post();
                echo ( '<li><a href = "' . get_the_permalink() . '" target = "_blank" />' . get_the_title(). '</a>');
                $this->listComments($ID, $author_email);
                echo "</li>";
                }
            }
            $output = $output . '</ul>';
            $output = $output . "Count: " . $this->count . "<br />";
            $output = $output . "Actions: " . $this->actions . "<br />";
        return $output;
        
    }
    
    public function countActions($taskID, $comments){
        $count = $this->count;
        $actions = $this->actions;
        if(
            ($taskID == 1199 ) or
            ($taskID == 701 ) or
            ($taskID == 549 ) or
            ($taskID == 529 ) or
            ($taskID == 525 ) or
            ($taskID == 514 ) or
            ($taskID == 648 )
            ){return;}
        
        $count = $count + 1;
        $actions = $actions + 1;        
        if(
            ($taskID == 646 ) or
            ($taskID == 643 ) or
            ($taskID == 641 ) or
            ($taskID == 639 ) or
            ($taskID == 637 ) or
            ($taskID == 633 ) or
            ($taskID == 631 ) or
            ($taskID == 627 ) or
            ($taskID == 625 ) or
            ($taskID == 621 ) or
            ($taskID == 617 ) or
            ($taskID == 603 ) or
            ($taskID == 599 ) or
            ($taskID == 596 )
            ){$actions = $actions + 1;}
        
        $this->count = $count;
        $this->actions = $actions;
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
                $output = '<p><span style = "background-color: green;">DONE</span>  <a onclick="window.location.href=this">refresh</a></p>';
                $this->countScreenShots($taskID);
            }
        } else {
            $output = $output . '<p><span style = "background-color: red;">No comment uploaded yet.</span>  <a onclick="window.location.href=this">refresh</a></p>';        }
            
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