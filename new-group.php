<!DOCTYPE html>
<html lang="cs/cz" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/master.min.css">
    <title>Přidání více učebnic najednou</title>
  </head>
  <body>
    <header>
      <?php include 'php-chunks/header.php' ?>
    </header>
    <h2>Přidání nového inzerátu</h2>
    <form class="" action="sendform.php?group=1" method="post" enctype="multipart/form-data">
      <div class="slide">
        <p>Jak se to dá souhrně nazvat?</p>
        <p>(třeba "Učebnice češtiny pro prvák")</p>
        Název: <input type="text" name="bookname" value="" required>
      </div>
      <div class="slide">
        <p>Pro jaký ročník jsou?</p>
        <img src="arrow.svg" alt="">
        <select name="schoolyear">
          <option value="1">Prvák</option>
          <option value="2">Druhák</option>
          <option value="3">Třeťák</option>
          <option value="4">Čtvrťák</option>
          <option value="0">Nejde určit</option>
        </select>
      </div>
      <div class="slide">
        <p>Jak vypadají?</p>
        <p>(jedna fotka stačí)</p>
        <input type="file" name="fileToUpload" id="fileToUpload" class="inputfile" required/>
        <label for="fileToUpload"><span>Vyber fotku</span></label>
      </div>
      <div class="slide">
        <p>Jak která a za kolik? A chceš něco dodat?</p>
        <p>(napiš ceny např. "čj - 110Kč, aj - 300Kč", k nim můžeš dodat svou poznámku)</p>
        Ceny a poznámka:<br><textarea name="note" value="" required></textarea>
      </div>
      <div class="slide">
        <?php include 'php-chunks/registration.php' ?>
        <input type="submit" name="" value="Odeslat">
      </div>
    </form>
    <footer>
      <p>© Ucebnicovka.cz 2019</p>
    </footer>
    <script type="text/javascript" src="js/master.js"></script>
    <script type="text/javascript">
      var fromForm;
      var mails;
      var names;
      var others;
      function registerAutofill(mail) {
        mails = [];
        names = [];
        others = [];
        fromForm = mail;
        <?php
          include 'php-chunks/mysql-credentials.php';

          $conn = new mysqli($servername, $username, $dbpassword, $dbname);
          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }

          $sql = $conn->prepare("SELECT UserName, Mail, OtherContact FROM main");
          $sql->execute();
          $result = $sql->get_result();

          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "mails.push('" . $row["Mail"] . "');";
              echo "names.push('" . $row["UserName"] . "');";
              echo "others.push('" . $row["OtherContact"] . "');";
            }
          }
        ?>
        mails.forEach(compare);

      }

      function compare(fromDB, index) {
        if(fromDB == fromForm) {
          document.getElementById("username").value = names[index];
          document.getElementById("username").style.border = "1px solid #82dd8c";
          document.getElementById("username").style.backgroundColor = "#f1fff1";
          document.getElementById("othercontact").value = others[index];
          document.getElementById("othercontact").style.border = "1px solid #82dd8c";
          document.getElementById("othercontact").style.backgroundColor = "#f1fff1";
        }
      }
    </script>
  </body>
</html>
