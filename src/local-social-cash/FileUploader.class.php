<?php
namespace LocalSocialCash; 

class FileUploader{    
    
    
    public function returnReportHTML(){
        /*
        firstName
        lastName
        email
        phone
        state
        FacebookUrl
        file
        */

        $output = <<<output

<form method='POST' enctype='multipart/form-data' name = 'task-prover-form'>
  <input type = "text" name = "email" />
  <input type="file" name ="userFile" />
  <input type="submit" name="file-from-form"/>
</form>

output;

        return $output;
    }


    public function listenToFormSubmission(){
        $filePath = $this->storeFile();
        global $post;
        $taskPageID = $post->ID;
        // Create post object
        $my_post = array(
            'post_title'    => 'Proof Subimssion',
            'post_content'  => 'Here is some content',
            'post_status'   => 'publish',
            //'post_author'   => 1,
            'post_type' => 'proof',
        );
        
        // Insert the post into the database
        $insertedPostID = wp_insert_post( $my_post );
        update_post_meta( $insertedPostID, 'proof-file', $filePath );
        update_post_meta( $insertedPostID, 'given-email', $givenEmail);
        update_post_meta( $insertedPostID, 'task-ID', $taskPageID);
        /*$user =  wp_get_current_user();
        global $post;
        $output = $output ."User ID : ". $user->ID;
        $output = $output ."<br> ";
        $output = $output ."Post ID : ". $post->ID;
        */
    }
    
    public function storeFile(){

      
require_once(ABSPATH . "wp-admin" . '/includes/image.php');
require_once(ABSPATH . "wp-admin" . '/includes/file.php');
require_once(ABSPATH . "wp-admin" . '/includes/media.php');

// Get the path to the upload directory.
$wp_upload_dir = wp_upload_dir();

//print_r($wp_upload_dir);

$name = basename($_FILES['userFile']['name']);

    
        $target_dir = wp_upload_dir();
        //$target_file = $target_dir['path']."/".basename($_FILES['userFile']['name']);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $temp = explode(".", $_FILES["userFile"]["name"]);
        $newfilename = $this->randomString();
        $newfilename = $newfilename . "." . end($temp);
        $target_file = $target_dir['path']."/" . $newfilename;
        
        move_uploaded_file($_FILES["userFile"]["tmp_name"], $target_file);


        $attachment = $wp_upload_dir['url'].'/'.$newfilename;
        //print_r($attachment);

    $image_id = wp_insert_attachment($attachment, $newfilename, $post_id);

    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
    //require_once( ABSPATH . 'wp-admin/includes/image.php' );
    
 
    // Generate the metadata for the attachment, and update the database record.
    $attach_data = wp_generate_attachment_metadata( $image_id, $name );

    wp_update_attachment_metadata( $image_id, $attach_data );
        return $target_file;


    }
        

    public function xxx(){
        if(is_user_logged_in()){ 
            $output = "";
            $user =  wp_get_current_user();
            global $post; 
            $output = $output ."User ID : ". $user->ID; 
            $output = $output ."<br> "; 
            $output = $output ."Post ID : ". $post->ID;
            return $output;
        }else{
            $url = get_home_url();
            wp_redirect( $url );
            exit;
        }
    }
    
    private function randomString($length = 20) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
}