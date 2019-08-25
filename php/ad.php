<!DOCTYPE html>
<html lang="cs/cz" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/master.min.css">
    <title></title>
  </head>
  <body>
    <header>
      <nav>
        <input id="check01" type="checkbox" name="menu">
        <label for="check01">
          <img id="menu-icon" src="menu.svg" alt="menu">
        </label>
        <ul>
          <li><a href="index.html">Úvod</a></li>
          <li><a href="myads.html">Moje inzeráty</a></li>
          <li><a href="new.html">Přidat</a></li>
          <li><a href="ads.php">Prohlížet</a></li>
          <li><a href="about.html">O projektu</a></li>
        </ul>
      </nav>
      <h1>Burza učebnic</h1>
      <p>Online burza učebnic</p>
    </header>
    <?php
      $servername = "localhost:3306";
      $username = "burza";
      $password = "DnaXn600UMfIDtxN";
      $dbname = "burza";

      $URL = $_GET["URL"];

      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT PhotoURL, BookName, BookAge, BookCondition, Price, Note, UserName, Mail, OtherContact FROM main WHERE URL='" . $URL ."'";
      $result = $conn->query($sql);

      // Prepare statement, avoid injection attack
      $sql = $conn->prepare("SELECT PhotoURL, BookName, BookAge, BookCondition, Price, Note, UserName, Mail, OtherContact FROM main WHERE URL=?");

      // Bind values
      $sql->bind_param("s", $URL);

      // Execute, check if successful, redirect
      if(!$sql->execute()) {
        // TODO: That if not working
      }

      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo "<div id='ad'>
                  <div id='img-wrapper'><img src=" . $row["PhotoURL"]. " alt='Ilustrace učebnice'/></div>
                  <h2>" . $row["BookName"]. "</h2>
                  <p>Stáří: " . $row["BookAge"] . " let</p>
                  <p>Stav: " . $row["BookCondition"] . "</p>
                  <p>Cena: " . $row["Price"] . " Kč</p>
                  <p>" . $row["Note"] . "</p>
                  <p>Od uživatele: " . $row["UserName"] . "</p>
                  <p>Kontakt: " . $row["Mail"] . "</p>
                  <p>Kontakt: " . $row["OtherContact"] . "</p>
                </div>";
        }
      } else {
        echo "0 results";
      }
      $sql->close();
    ?>
  </body>
</html>
