<?php

namespace LocalSocialCash;

class ClientReport{
    
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
                echo ( '<li> ++ <a href = "' . get_the_permalink() . '" target = "_blank" />' . get_the_title(). '</a>');
                $this->listComments($ID, $author_email);
                echo "</li>";
                }
            }
            $output = $output . '</ul>';
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
                $output = '<p><span style = "background-color: green;">DONE</span>  <a onclick="window.location.href=this">refresh</a></p>';
                //$output = $output . '<p>' . $comment->comment_attachment . '</p>';
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