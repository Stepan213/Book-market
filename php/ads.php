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

      $conn = new mysqli($servername, $username, $password, $dbname);
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT URL, BookName, PhotoURL, Price, BookCondition FROM main";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "<a href='ad.php?URL=". $row["URL"] ."' class='list-block'>
                  <div id='img-wrapper'><img src=" . $row["PhotoURL"]. " alt='Ilustrace učebnice'/></div>
                  <strong>" . $row["BookName"]. "</strong>
                  <p>" . $row["Price"]. " Kč</p>
                  <p>" . $row["BookCondition"]. "</p>
                </a>";
        }
      } else {
        echo "0 results";
      }
      $conn->close();
    ?>
  </body>
</html>
