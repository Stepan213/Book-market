<!DOCTYPE html>
<html lang="cs/cz" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/master.min.css">
    <title>Všechny inzeráty</title>
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
    <h2>Všechny inzeráty</h2>
    <div id="ads-options">
      <form class="" action="ads.php" method="post">
          <p>Filtr podle předmětu:</p>
          <img src="arrow.svg" alt="">
          <select name="subject">
            <option value="multiple">Víc předmětů</option>
            <?php
              if(!count($_POST)) {
                $subject = "other";
                $school_year = "0";
              } else {
                $subject = $_POST['subject'];
                $school_year = $_POST['schoolyear'];
              }
            ?>
            <option <?php if ($subject == "aj" ) echo 'selected'; ?> value="aj">Aj</option>
            <option <?php if ($subject == "cj" ) echo 'selected'; ?> value="cj">Čj</option>
            <option <?php if ($subject == "nj" ) echo 'selected'; ?> value="nj">Nj</option>
            <option <?php if ($subject == "fy" ) echo 'selected'; ?> value="fy">Fy</option>
            <option <?php if ($subject == "ma" ) echo 'selected'; ?> value="ma">Ma</option>
            <option <?php if ($subject == "ch" ) echo 'selected'; ?> value="ch">Ch</option>
            <option <?php if ($subject == "de" ) echo 'selected'; ?> value="de">Dě</option>
            <option <?php if ($subject == "ze" ) echo 'selected'; ?> value="ze">Ze</option>
            <option <?php if ($subject == "zsv" ) echo 'selected'; ?> value="zsv">ZsV</option>
            <option <?php if ($subject == "bi" ) echo 'selected'; ?> value="bi">Bi</option>
            <option <?php if ($subject == "other" ) echo 'selected'; ?> value="other">Jiné</option>
          </select>
          <p>Filtr podle ročníku:</p>
          <img src="arrow.svg" alt="">
          <select name="schoolyear">
            <option <?php if ($school_year == "1" ) echo 'selected'; ?> value="1">Prvák</option>
            <option <?php if ($school_year == "2" ) echo 'selected'; ?> value="2">Druhák</option>
            <option <?php if ($school_year == "3" ) echo 'selected'; ?> value="3">Třeťák</option>
            <option <?php if ($school_year == "4" ) echo 'selected'; ?> value="4">Čtvrťák</option>
            <option <?php if ($school_year == "0" ) echo 'selected'; ?> value="0">Nejde určit</option>
          </select>
        <input type="submit" name="" value="Použít filtry">
      </form>
    </div>
    <div id="list-block-wrapper">
    <?php
      $servername = "localhost:3306";
      $username = "burza";
      $dbpassword = "DnaXn600UMfIDtxN";
      $dbname = "burza";

      $conn = new mysqli($servername, $username, $dbpassword, $dbname);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      if(count($_POST)) {
        $subject = $_POST['subject'];
        $school_year = $_POST['schoolyear'];
        $sql = $conn->prepare("SELECT URL, BookName, PhotoURL, Price FROM main WHERE Subject=? AND SchoolYear=? ORDER BY IsGroup DESC");

        $sql->bind_param("si", $subject, $school_year);
        $sql->execute();

        $result = $sql->get_result();

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "<a href='ad.php?URL=". $row["URL"] ."' class='list-block'>
                    <div id='img-wrapper'><img src=" . $row["PhotoURL"]. " alt='Ilustrace učebnice'/></div>
                    <strong>" . $row["BookName"]. "</strong>
                    <p>" . $row["Price"]. " Kč</p>
                  </a>";
          }
        } else {
          echo "<p class='error-message'>Vypadá to, že na burze zrovna žádné takové inzeráty nejsou. Chceš to napravit a <a href='new.html'>přidat inzerát</a>?</p>";
        }
      }
      else {
        $sql = "SELECT URL, BookName, PhotoURL, Price FROM main ORDER BY IsGroup DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "<a href='ad.php?URL=". $row["URL"] ."' class='list-block'>
                    <div id='img-wrapper'><img src=" . $row["PhotoURL"]. " alt='Ilustrace učebnice'/></div>
                    <strong>" . $row["BookName"]. "</strong>
                    <p>" . $row["Price"]. " Kč</p>
                  </a>";
          }
        } else {
          echo "<p class='error-message'>Vypadá to, že na burze zrovna žádné inzeráty nejsou. Chceš to napravit a <a href='new.html'>přidat inzerát</a>?</p>";
        }
      }
      $conn->close();
    ?>
  </div>
    <footer>
      <p>© Burza Učebnic 2019</p>
    </footer>
  </body>
</html>
