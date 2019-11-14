<?php
ob_start();
session_start();
require_once 'dbconnect.php';

include_once 'dbconnect.php';
//Check that we have a file and i don't have any error
if((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
  //Check if the file is JPEG image and it's size is less than 350Kb
  $filename = basename($_FILES['uploaded_file']['name']);
  $ext = substr($filename, strrpos($filename, '.') + 1);
  if ((($ext == "jpg") || ($ext == "png")) && (($_FILES["uploaded_file"]["type"] == "image/jpeg") || ($_FILES["uploaded_file"]["type"] == "image/png")) && 
  ($_FILES["uploaded_file"]["size"] < 90000000)) { #BYTES
    //Determine the path to which we want to save this file
      $newname = dirname(__FILE__).'/uploads/'.$filename;
      //Check if the file with the same name is already exists on the server
      if (!file_exists($newname)) {
        //Attempt to move the uploaded file to it's new place
        if ((move_uploaded_file($_FILES['uploaded_file']['tmp_name'],$newname))) {
           echo "It's done! The file has been saved as: ".$newname;
           $sql = "UPDATE users SET userAvatar = 'uploads/$filename' WHERE userId={$_SESSION['user']};";
           // UPDATE `users` SET `userAvatar`= WHERE userId=''
           mysqli_query($conn,$sql);
        } else {
           echo "Error: A problem occurred during file upload!";
        }
      } else {
         echo "Error: File ".$_FILES["uploaded_file"]["name"]." already exists";
      }
  } else {
     echo "Error: Only .jpg and .png images under 9MB are accepted for upload";
  }
} else {
 echo "Error: No file uploaded";
}

$sqli = "SELECT * FROM users";
$res = mysqli_query($conn,$sqli);
$result = $res->fetch_all(MYSQLI_ASSOC);

foreach ($result as $row) {
  echo "<img src='".$row["name"]."'>";
}
?>

<html> 
<body>
  <form enctype="multipart/form-data" action="upload.php" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
    Choose a file to upload: <input name="uploaded_file" type="file" />
    <input type="submit" value="Upload" />
  </form> 

</body> 
</html>
<?php ob_end_flush(); ?>