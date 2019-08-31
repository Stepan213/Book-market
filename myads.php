<!DOCTYPE html>
<html lang="cs/cz" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/master.min.css">
    <title>Moje inzeráty</title>
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
      <a href="index.html"><h1>Ucebnicovka<span>.cz</span></h1></a>
      <p>Online burza učebnic</p>
      <div id="line"></div>
      </header>
      <h2>Moje inzeráty</h2>
      <div id="list-block-wrapper">
      <?php
        $user_mail = $_POST['usermail'];
        $user_password = $_POST['password'];

        $servername = "localhost:3306";
        $username = "burza";
        $dbpassword = "DnaXn600UMfIDtxN";
        $dbname = "burza";

        // Try connect to a mysql database
        $conn = new mysqli($servername, $username, $dbpassword, $dbname);
        if($conn->connect_error) {
          die('Connect Error:' . $conn->connect_error);
        }

        // Prepare statement, avoid injection attack
        $sql = $conn->prepare("SELECT ID, Password, URL, BookName, PhotoURL FROM main WHERE Mail=?");

        // Bind values
        $sql->bind_param("s", $user_mail);

        $sql->execute();

        $result = $sql->get_result();

        $displayed_results = 0;

        if(mysqli_num_rows($result)>0) {
          while($row = $result->fetch_assoc()) {
            if(password_verify($user_password, $row["Password"])) {
              $code = round(microtime(true));
              echo "<a href='myad.php?URL=". $row["URL"] . "&Code=" . $code . "' class='list-block'>
                      <div id='img-wrapper'><img src=" . $row["PhotoURL"]. " alt='Ilustrace učebnice'/></div>
                      <strong>" . $row["BookName"]. "</strong>
                    </a>";
              $displayed_results++;
              $sql = ("UPDATE main SET Code = '" . $code . "' WHERE ID = " . $row["ID"]);
              $conn->query($sql);
            }
          }
        } else {
          echo "<p class='error-message'>Tenhle E-Mail v databázi nemám :-/ Chceš to <a href='myads-login.html'>zkusit znovu</a>?<p>";
        }

        if(!$displayed_results) {
          echo "<p class='error-message'>Heslo k tomuto E-Mailu není správné, nebo k němu neexistují žádné inzeráty. Chceš to <a href='myads-login.html'>zkusit znovu</a>?<p>";
        }
        $conn->close();
      ?>
    </div>
      <footer id="fixed-footer">
        <p>© Ucebnicovka.cz 2019</p>
      </footer>
  </body>
</html>
