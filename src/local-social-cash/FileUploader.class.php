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
echo $GLOBALS['msg'];
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
// Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["userFile"]["tmp_name"]);
    if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        //echo "File is not an image.";
        $uploadOk = 0;
    }

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["userFile"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    //print_r($target_file);
   $temp = explode(".", $_FILES["userFile"]["name"]);
   $newfilename = round(microtime(true)) . '.' . end($temp);
    if (move_uploaded_file($_FILES["userFile"]["tmp_name"], $target_file. $newfilename)) {
   $GLOBALS['msg'] =  "The file ". basename( $_FILES["userFile"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
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
}