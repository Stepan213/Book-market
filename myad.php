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
          <li><a href="new/new-choice.html">Přidat</a></li>
          <li><a href="ads.php">Prohlížet</a></li>
          <li><a href="about.html">O projektu</a></li>
        </ul>
      </nav>
      <a href="index.html"><h1>Ucebnicovka<span>.cz</span></h1></a>
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
      $Code = $_GET["Code"];

      $conn = new mysqli($servername, $username, $dbpassword, $dbname);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      if(isset($_GET["action"])) {
        if($_GET["action"] == "delete") {
          $sql = $conn->prepare("DELETE FROM main WHERE Code=?");
          $sql->bind_param("s", $Code);
          if($sql->execute()) {
            echo "<p class='error-message'>Inzerát byl úspěšně smazán. Chceš se vrátit na <a href='ads.php'>stránku s inzeráty</a>?</p>";
          } else {
            echo "<p class='error-message'>Inzerát se nepodařilo smazat. Chceš se vrátit na <a href='ads.php'>stránku s inzeráty</a>?</p>";
          }
        }
        if($_GET["action"] == "modify") {
          $book_name = $_POST['bookname'];
          $note = $_POST['note'];
          $price = $_POST['price'];
          $other_contact = $_POST['othercontact'];

          $sql = $conn->prepare("UPDATE main SET BookName=?, Note=?, Price=?, OtherContact=? WHERE URL=?");
          $sql->bind_param("ssiss", $book_name, $note, $price, $other_contact, $URL);
          $sql->execute();
        }
        $sql->close();
        exit();
      }

      // Prepare statement, avoid injection attack
      $sql = $conn->prepare("SELECT PhotoURL, BookName, Price, Note, OtherContact, IsGroup, Code FROM main WHERE URL=?");

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
          if($row["Code"] == $Code) {
          if($row["IsGroup"]) {
            $price = "' disabled>";
          } else {
            $price = $row["Price"] . "' required>";
          }
          // Generate HTML
          echo "<div id='img-wrapper'><img src=" . $row["PhotoURL"]. " alt='Ilustrace učebnice'/></div>
                  <div id='text'>
                    <form action='myad.php?action=modify&URL=". $URL . "&Code=" . $Code . "' method='post'>
                      <div>
                        <p>Chceš inzerát přejmenovat?</p>
                        <input type='text' name='bookname' id='myad-heading' value='" . $row["BookName"] . "' required><br>
                      </div>
                      <div>
                        <p>Chceš upravit cenu?</p>
                        <p>(U inzerátu s více učebnicemi najednou cena editovat nejde.)</p>
                        <input type='number' name='price' min='0' value='" . $price . " Kč<br>
                      </div>
                      <div>
                        <p>Chceš ještě něco dodat? Nebo upravit?</p>
                        <textarea name='note'>" . $row["Note"] . "</textarea><br>
                      </div>
                      <div>
                        <p>Chceš přidat nějaký svůj další kontakt?</p>
                        Další kontakt: <input type='text' name='othercontact' value='" . $row["OtherContact"] . "' required><br>
                      </div>
                      <div>
                        <input type='submit' value='Potvrdit úpravu'>
                      </div>
                    </form>
                  </div>
                  <form action='myad.php?action=delete&URL=". $URL . "&Code=" . $Code . "' method='post' id='delete-form'>
                    <div>
                      <p>Smazání inzerátu</p>
                      <p>Tlačítkem níže můžeš inzerát smazat. Nijak to neovlivní Tvé ostatní inzeráty.</p>
                      <p>Nejde to vrátit, tak pozor :-)</p>
                      <input type='submit' id='delete-button' value='Smazat inzerát'>
                    </div>
                  </form>
                ";
        } else {
          echo "<p class='error-message'>Inzerát se nepodařilo načíst z bezpečnostních důvodů. Chceš se vrátit na <a href='ads.php'>stránku s inzeráty</a>?</p>";
        }
        }
      } else {
        echo "<p class='error-message'>Inzerát se nepodařilo načíst. Chceš se vrátit na <a href='ads.php'>stránku s inzeráty</a>?</p>";
      }
      $sql->close();
    ?>
    </div>
    <footer>
      <p>© Ucebnicovka.cz 2019</p>
    </footer>
  </body>
</html>
