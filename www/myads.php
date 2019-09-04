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
      <?php include 'php-chunks/header.php' ?>
    </header>
    <h2>Moje inzeráty</h2>
    <div id="list-block-wrapper">
    <?php
      //Hide all errors to user
      error_reporting(0);
      ini_set('display_errors', 0);

      // User login credentials
      $user_mail = $_POST['usermail'];
      $user_password = $_POST['password'];

      // MySQL credentials
      include 'php-chunks/mysql-credentials.php';

      // Try connect to a mysql database
      $conn = new mysqli($servername, $username, $dbpassword, $dbname);
      if($conn->connect_error) {
        die("<p class='error-message'>Vypadá to, že přihlašování zrovna teď nefunguje. V případě potřeby úpravy/smazání tvých osobních údajů nás kontaktuj přes kontakt na stránce <a href='about.php'>O projektu</a>.</p>");
      }
      // Prepare statement, avoid injection attack
      $sql = $conn->prepare("SELECT ID, Password, URL, BookName, PhotoURL FROM main WHERE Mail=?");
      $sql->bind_param("s", $user_mail);
      $sql->execute();
      $result = $sql->get_result();
      $displayed_results = 0;
      if(mysqli_num_rows($result)>0) {
        while($row = $result->fetch_assoc()) {
          if(password_verify($user_password, $row["Password"])) {
            $code = random_int(100000, 999999);
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
        echo "<p class='error-message'>Tenhle E-Mail v databázi nemám :-/ Chceš to <a href='myads-login.php'>zkusit znovu</a>?<p>";
      }
      if(!$displayed_results) {
        echo "<p class='error-message'>Heslo k tomuto E-Mailu není správné, nebo k němu neexistují žádné inzeráty. Chceš to <a href='myads-login.php'>zkusit znovu</a>?<p>";
      }
      $conn->close();
    ?>
    </div>
      <footer>
        <p>© Ucebnicovka.cz 2019</p>
      </footer>
  </body>
</html>
