<?php
include("mysqli_connect.php");
$user_id = 68;

  // File upload path
if(isset($_POST['submit'])){
 
  $profile_image = $_FILES['file']['profile_image'];
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES["file"]["profile_image"]);

  // Select file type
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Valid file extensions
  $extensions_arr = array("jpg","jpeg","png","gif");

  // Check extension
  if( in_array($imageFileType,$extensions_arr) ){
 
     // Insert record
     $query = "insert into USER (profile_image) values('".$profile_image."')";
     mysqli_query($con,$query);
  
     // Upload file
     move_uploaded_file($_FILES['file']['tmp_profile_image'],$target_dir.$profile_image);
     
     echo "good";

  } else {
    echo "bad";
  }
 
}

    echo "
    <a href='profile.php'>profile</a>
    
    <form method='post' action='profile_image.php' enctype='multipart/form-data'>
    <p>select image to upload:</p>
    <input type='file' name='file' />
    <input type='submit' name='submit' value='upload' />
    </form>";
  
echo "</div>";
 
$sql = "select profile_image from USER where $user_id = 68";
$result = mysqli_query($con,$sql);
$row = mysqli_fetch_array($result);

$image = $row['profile_image'];
$image_src = "uploads/".$image;

?>
<img src='<?php echo $image_src;  ?>'>
