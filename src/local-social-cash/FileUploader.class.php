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
  <input type="file" name ="userFile" />
  <input type="submit" name="file-from-form"/>
</form>

output;

        return $output;
    }


    public function listenToFormSubmission(){
        $filePath = $this->storeFile();
        // Create post object
        $my_post = array(
            'post_title'    => 'Proof Subimssion',
            'post_content'  => 'Here is some content',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type' => 'proof',
        );
        
        // Insert the post into the database
        $ID = wp_insert_post( $my_post );
        update_post_meta( $ID, 'proof-file', $filePath );
        /*$user =  wp_get_current_user();
        global $post;
        $output = $output ."User ID : ". $user->ID;
        $output = $output ."<br> ";
        $output = $output ."Post ID : ". $post->ID;
        */
    }
    
    public function storeFile(){
        $target_dir = wp_upload_dir();
        //$target_file = $target_dir['path']."/".basename($_FILES['userFile']['name']);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $temp = explode(".", $_FILES["userFile"]["name"]);
        $newfilename = $this->randomString();
        $newfilename = $newfilename . "." . end($temp);
        $target_file = $target_dir['path']."/" . $newfilename;
        //echo("image file type : $imageFileType <br /> target_file $target_file<br /> newfilename $newfilename");
        //die();
        move_uploaded_file($_FILES["userFile"]["tmp_name"], $target_file);
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