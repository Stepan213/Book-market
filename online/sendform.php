<?php
$target_img_dir = "uploads/";
$target_file = $target_img_dir . basename($_FILES["fileToUpload"]["name"]);
$upload_ok = 1;
$image_file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$temp = explode(".", $_FILES["fileToUpload"]["name"]);
$URL = round(microtime(true));
$newfilename = $URL . '.' . end($temp);

$error_message = null;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $upload_ok = 1;
    } else {
        $error_message = "Zvolený soubor pravý není obrázek.";
        $upload_ok = 0;
    }
}
// Check if file already exists
if (file_exists($target_file) && $upload_ok) {
    $error_message = "Obrázek se nezdařilo nahrát, interní chyba: Shoda systémových jmen.";
    $upload_ok = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000 && $upload_ok) {
    $error_message = "Nahraný obrázek je větší než 5MB.";
    $upload_ok = 0;
}
// Allow certain file formats
if($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg"
&& $image_file_type != "gif"  && $upload_ok) {
    $error_message = "Pouze JPG, JPEG, PNG a GIF formáty jsou povolené.";
    $upload_ok = 0;
}

// Try upload file
if($upload_ok) {
  if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_img_dir . $newfilename)) {
    $error_message = "Omlouvám se, obrázek se nepodařilo nahrát. Zkuste to prosím znovu.";
  }
}

// Determine if ad is single book or group (only single book form has 'subject' field)
$group = !isset($_POST['subject']);

// Get variables from html form
$book_name = $_POST['bookname'];
$school_year = $_POST['schoolyear'];
$note = $_POST['note'];
$user_name = $_POST['username'];
$user_mail = $_POST['mail'];
$other_contact = $_POST['othercontact'];
$unhashed_password = $_POST['password'];
if(!$group) {
  $subject = $_POST['subject'];
  $price = $_POST['price'];
}

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

if($group) {
  // Prepare statement, avoid injection attack
  $sql = $conn->prepare("INSERT INTO main (BookName, SchoolYear, URL, PhotoURL, Note, UserName, Mail, OtherContact, Password, IsGroup) VALUES
  (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  // Bind values
  $sql->bind_param("sisssssssi", $book_name, $school_year, $URL, $photoURL, $note, $user_name, $user_mail, $other_contact, $password, $group);
} else {
  // Prepare statement, avoid injection attack
  $sql = $conn->prepare("INSERT INTO main (BookName, Subject, SchoolYear, URL, PhotoURL, Price, Note, UserName, Mail, OtherContact, Password) VALUES
  (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  // Bind values
  $sql->bind_param("ssississsss", $book_name, $subject, $school_year, $URL, $photoURL, $price, $note, $user_name, $user_mail, $other_contact, $password);
}

// Execute, check if successful, redirect
if($sql->execute() && !$error_message) {
  header("Location: ad.php?URL=" . $URL);
  die();
} else {
  echo "<p class='error-message'>Při přidávání se něco pokazilo :-/ Chceš to <a href='new.html'>zkusit znovu</a>?<p>";
  if($error_message) {
    echo "<p class='error-message'>Problémy udělal obrázek: " . $error_message . "<p>";
  }
}

$sql->close();
?>
