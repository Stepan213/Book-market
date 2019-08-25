<?php
$target_img_dir = "uploads/";
$target_file = $target_img_dir . basename($_FILES["fileToUpload"]["name"]);
$upload_ok = 1;
$image_file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$temp = explode(".", $_FILES["fileToUpload"]["name"]);
$URL = round(microtime(true));
$newfilename = $URL . '.' . end($temp);

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $upload_ok = 1;
    } else {
        echo "Zvolený soubor není obrázek.";
        $upload_ok = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Obrázek se nezdařilo nahrát, interní chyba: Shoda systémových jmen. Zkuste to prosím znovu.";
    $upload_ok = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Nahraný obrázek je větší než 5MB.";
    $upload_ok = 0;
}
// Allow certain file formats
if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg"
&& $image_file_type != "gif" ) {
    echo "Omlouvám se, pouze JPG, JPEG, PNG a GIF formáty jsou povolené.";
    $upload_ok = 0;
}
// Check if $upload_ok is set to 0 by an error
if ($upload_ok == 0) {
    echo "Omlouvám se, obrázek se nepodařilo nahrát. Zkuste to prosím znovu.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_img_dir . $newfilename)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Omlouvám se, obrázek se nepodařilo nahrát. Zkuste to prosím znovu.";
    }
}


// Get variables from html form
$book_name = $_POST['bookname'];
$book_age = $_POST['bookage'];
$condition = $_POST['condition'];
$price = $_POST['price'];
$note = $_POST['note'];
$user_name = $_POST['username'];
$user_mail = $_POST['mail'];
$other_contact = $_POST['othercontact'];
$unhashed_password = $_POST['password'];

// Get photo URL
$photoURL = $target_img_dir . $newfilename;

// Hash password
$password = password_hash($unhashed_password, PASSWORD_DEFAULT, ["cost" => 10]);

      $servername = "c100um.forpsi.com";
      $username = "f106697";
      $dbpassword = "3nhfFP5";
      $dbname = "f106697";

// Try connect to a mysql database
$conn = new mysqli($servername, $username, $dbpassword, $dbname);
if($conn->connect_error) {
  die('Connect Error:' . $conn->connect_error);
}

// Prepare statement, avoid injection attack
$sql = $conn->prepare("INSERT INTO main (BookName, URL, PhotoURL, BookAge, BookCondition, Price, Note, UserName, Mail, OtherContact, Password) VALUES
(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Bind values
$sql->bind_param("sssisisssss", $book_name, $URL, $photoURL, $book_age, $condition, $price, $note, $user_name, $user_mail, $other_contact, $password);

// Execute, check if successful, redirect
if($sql->execute()) {
  header("Location: ad.php?URL=" . $URL);
  die();
} else {
  "<p class='error-message'>Při přidávání se něco pokazilo :-/ Chceš to <a href='new.html'>zkusit znovu</a>?<p>";
}

$sql->close();
?>
