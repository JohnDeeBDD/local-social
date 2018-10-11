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

<form method='POST' enctype='multipart/form-data'>
  <input type="file" name ="userFile" />
  <input type="submit" name="file-from-form"/>
</form>

output;

        return $output;
    }


    public function listenToFormSubmission(){

        $target_dir = wp_upload_dir();
        $target_file = $target_dir['path']."/".basename($_FILES['userFile']['name']);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $temp = explode(".", $_FILES["userFile"]["name"]);
        $newfilename = $this->randomString();
        $newfilename = $newfilename . "." . end($temp);
        if (move_uploaded_file($_FILES["userFile"]["tmp_name"], $target_file . $newfilename)){
            echo "The file ". $newfilename . " has been uploaded.";
         }else{
            echo "Sorry, there was an error uploading your file.";
        }
//}
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