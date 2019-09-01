<!DOCTYPE html>
<html lang="cs/cz" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/master.min.css">
    <title>Inzerát</title>
  </head>
  <body>
    <header>
      <?php include 'php-chunks/header.php' ?>
    </header>
    <?php
      //Hide all errors to user
      error_reporting(0);
      ini_set('display_errors', 0);

      //Get specific ad "URL"
      $URL = $_GET["URL"];

      //MySQL credentials
      include 'php-chunks/mysql-credentials.php';

      //Connect to MySQL
      $conn = new mysqli($servername, $username, $dbpassword, $dbname);
      if ($conn->connect_error) {
        die("<p class='error-message'>Inzerát se nepodařilo načíst. Chceš se vrátit na <a href='ads.php'>stránku s inzeráty</a>?</p>");
      }

      // Prepare statement, avoid injection attack
      if(!$sql = $conn->prepare("SELECT PhotoURL, BookName, Price, Note, UserName, Mail, OtherContact, IsGroup FROM main WHERE URL=?")) {
        echo "<p class='error-message'>Inzerát se nepodařilo načíst. Chceš se vrátit na <a href='ads.php'>stránku s inzeráty</a>?</p>";
        $sql->close();
        exit();
      }
      $sql->bind_param("s", $URL);

      // Execute, check if successful, redirect
      if(!$sql->execute()) {
        echo "<p class='error-message'>Inzerát se nepodařilo načíst. Chceš se vrátit na <a href='ads.php'>stránku s inzeráty</a>?</p>";
        $sql->close();
        exit();
      }

      $result = $sql->get_result();

      if ($result->num_rows) {
        $row = $result->fetch_assoc();
        // Hide price tag if ad is group of books
        if($row["IsGroup"]) {
          $price = "";
        } else {
          $price = "<p>Cena: " . $row["Price"] . " Kč</p>";
        }
        // Generate HTML
        echo "<div id='ad'>
                <div id='img-wrapper'><img src=" . $row["PhotoURL"]. " alt='Ilustrace učebnice'/></div>
                <div id='text'>
                <h2>" . $row["BookName"]. "</h2>
                " . $price . "
                <p>" . $row["Note"] . "</p>
                <p>Od uživatele: " . $row["UserName"] . "</p>
                <p>Kontakt: <a href='mailto:" . $row["Mail"] . "'>" . $row["Mail"] . "</a></p>
                <p>Další kontakt: " . $row["OtherContact"] . "</p>
                </div>
              </div>";

      } else {
        echo "<p class='error-message'>Inzerát se nepodařilo načíst. Chceš se vrátit na <a href='ads.php'>stránku s inzeráty</a>?</p>";
      }
      $sql->close();
    ?>
    <footer>
      <p>© Ucebnicovka.cz 2019</p>
    </footer>
  </body>
</html>
