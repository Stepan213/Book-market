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
      <nav>
        <input id="check01" type="checkbox" name="menu">
        <label for="check01">
          <img id="menu-icon" src="menu.svg" alt="menu">
        </label>
        <ul>
          <li><a href="index.html">Úvod</a></li>
          <li><a href="myads-login.html">Moje inzeráty</a></li>
          <li><a href="new-choice.html">Přidat</a></li>
          <li><a href="ads.php">Prohlížet</a></li>
          <li><a href="about.html">O projektu</a></li>
        </ul>
      </nav>
      <a href="index.html"><h1>Burza učebnic</h1></a>
      <p>Online burza učebnic</p>
      <div id="line"></div>
    </header>
    <div id="myad">
    <?php
      $servername = "localhost:3306";
      $username = "burza";
      $dbpassword = "DnaXn600UMfIDtxN";
      $dbname = "burza";

      $URL = $_GET["URL"];

      $conn = new mysqli($servername, $username, $dbpassword, $dbname);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Prepare statement, avoid injection attack
      $sql = $conn->prepare("SELECT PhotoURL, BookName, Price, Note, OtherContact, IsGroup FROM main WHERE URL=?");

      // Bind values
      $sql->bind_param("s", $URL);

      // Execute, check if successful, redirect
      if(!$sql->execute()) {
        // TODO: That if not working
      }

      $result = $sql->get_result();

      if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          if($row["IsGroup"]) {
            $price = "";
          } else {
            $price = "<input type='number' name='price' min='0' value='" . $row["Price"] . "' required> Kč";
          }
          // Generate HTML
          echo "<div id='img-wrapper'><img src=" . $row["PhotoURL"]. " alt='Ilustrace učebnice'/></div>
                  <div id='text'>
                    <form action='modify.php' method='post'>
                      <div>
                        <input type='text' name='bookname' id='myad-heading' value='" . $row["BookName"] . "' required>
                        " . $price . "
                        <textarea name='note' required>" . $row["Note"] . "</textarea>
                        Další kontakt: <input type='text' name='OtherContact' value='" . $row["OtherContact"] . "' required>
                        <input type='submit' value='Potvrdit úpravu'>
                      </div>
                    </form>
                  </div>
                ";
        }
      } else {
        echo "<p class='error-message'>Inzerát se nepodařilo načíst. Chceš se vrátit na <a href='ads.php'>stránku s inzeráty</a>?</p>";
      }
      $sql->close();
    ?>
    <form action='delete.php' method='post' id='delete-form'>
      <div>
        <p>Smazání inzerátu</p>
        <p>Tlačítkem níže můžeš inzerát smazat. Nijak to neovlivní Tvé ostatní inzeráty.</p>
        <p>Nejde to vrátit, tak pozor :-)</p>
        <input type='submit' id='delete-button' value='Smazat inzerát'>
      </div>
    </form>
    </div>
    <footer>
      <p>© Burza Učebnic 2019</p>
    </footer>
  </body>
</html>
