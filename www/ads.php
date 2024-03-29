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
      <?php include 'php-chunks/header.php' ?>
    </header>
    <h2>Všechny inzeráty</h2>
    <div id="ads-options">
      <p>(Filtry nemusejí vždy být úplně přesné.)</p>
      <form class="" action="ads.php" method="get">
          <p>Filtr podle předmětu:</p>
          <select name="subject">
            <?php
              // If filters are set, initialize them
              if(!count($_GET)) {
                $subject = "multiple";
                $school_year = "1";
              } else {
                $subject = $_GET['subject'];
                $school_year = $_GET['schoolyear'];
              }
            ?>
            <option <?php if ($subject == "multiple" ) echo 'selected'; ?> value="multiple">Nezáleží</option>
            <option <?php if ($subject == "aj" ) echo 'selected'; ?> value="aj">Aj</option>
            <option <?php if ($subject == "cj" ) echo 'selected'; ?> value="cj">Čj</option>
            <option <?php if ($subject == "nj" ) echo 'selected'; ?> value="nj">Nj</option>
            <option <?php if ($subject == "fj" ) echo 'selected'; ?> value="fj">Fj</option>
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
          <select name="schoolyear">
            <option <?php if ($school_year == "1" ) echo 'selected'; ?> value="1">Prvák</option>
            <option <?php if ($school_year == "2" ) echo 'selected'; ?> value="2">Druhák</option>
            <option <?php if ($school_year == "3" ) echo 'selected'; ?> value="3">Třeťák</option>
            <option <?php if ($school_year == "4" ) echo 'selected'; ?> value="4">Čtvrťák</option>
            <option <?php if ($school_year == "0" ) echo 'selected'; ?> value="0">Neurčeno/Víceleté</option>
          </select>
        <input type="submit" name="" value="Použít filtry">
      </form>
    </div>
    <div id="list-block-wrapper">
    <?php
      //Hide all errors to user
      error_reporting(0);
      ini_set('display_errors', 0);

      // MySQL credentials
      include 'php-chunks/mysql-credentials.php';

      // Connect to MySQL
      $conn = new mysqli($servername, $username, $dbpassword, $dbname);
      if ($conn->connect_error) {
        die("<p class='error-message'>Vypadá to, že inzeráty jsou momentálně nedostupné. Zkus to prosím zachvíli, čas si můžeš zkrátit přečtením stránky <a href='about.php'>O tomto projektu</a>.</p>");
      }

      // If using filters
      if(count($_GET)) {
        // If subject = multiple
        if($subject == "multiple") {
          // If school year not set
          if($school_year == "0") {
            $sql = $conn->prepare("SELECT URL, BookName, PhotoURL, Price, IsGroup FROM main ORDER BY IsGroup DESC");
          // If school year is set
          } else {
            $sql = $conn->prepare("SELECT URL, BookName, PhotoURL, Price, IsGroup FROM main WHERE SchoolYear=? ORDER BY IsGroup DESC");
            $sql->bind_param("i", $school_year);
          }
          $sql->execute();
          $result = $sql->get_result();
        // If subject is set
        } else {
          // If school year doesn't matter
          if($school_year == "0") {
            $sql = $conn->prepare("SELECT URL, BookName, PhotoURL, Price, IsGroup, Note FROM main WHERE Subject=? OR IsGroup ORDER BY IsGroup ASC");
            $sql->bind_param("s", $subject);
          // If school year matters
          } else {
            $sql = $conn->prepare("SELECT URL, BookName, PhotoURL, Price, IsGroup, Note FROM main WHERE SchoolYear=? AND (Subject=? OR IsGroup) ORDER BY IsGroup ASC");
            $sql->bind_param("is", $school_year, $subject);
          }

          $sql->execute();
          $result = $sql->get_result();

          // If there are some results, half filtered (only single book ads are already filtered)
          if($result->num_rows > 0) {
            // Get subject spelling table
            $subjects_sql = $conn->prepare("SELECT Base, BaseD, Longer, LongerD, Short, ShortD, Other FROM subjects WHERE Base=?");
            $subjects_sql->bind_param("s", $subject);

            $ad_found = false;
            $error_message_count = 0;

            $valid_results = array();

            // While there are remaining not displayed ads
            while($row = $result->fetch_assoc()) {
              // Put Note and BookName to lowercase for easier comparing
              $note = mb_strtolower($row["Note"], 'UTF-8');
              $book_name = mb_strtolower($row["BookName"], 'UTF-8');

              // Refill subject spelling table
              $subjects_sql->execute();
              $subjects = $subjects_sql->get_result();
              $subject_spelling = $subjects->fetch_assoc();
              $match_found = false;
              // Try out each spelling
              foreach ($subject_spelling as $spelling) {
                // Ignore if current spelling is empty
                if($spelling == "") {
                  continue;
                }
                // If ad is a group of books and spelling matches, set boolean $match_found to true
                if($row["IsGroup"] && (strpos($note, $spelling) !== false || strpos($book_name, $spelling) !== false)) {
                  $match_found = true;
                  break;
                }
              }

              $subjects->free();

              // If ad isn't group or match in spelling is found
              if(!$row["IsGroup"] || $match_found) {
                // Put current row to $valid_results to be displayed later
                $valid_results[] = $row;
                $match_found = false;
                $ad_found = true;
              }
            }

            // If there are any valid results
            if(!empty($valid_results)) {
              // Display them
              foreach ($valid_results as $row) {
                echo "<a href='ad.php?URL=". $row["URL"] ."' class='list-block'>
                      <div id='img-wrapper'><img src=" . $row["PhotoURL"]. " alt='Ilustrace učebnice'/></div>
                      <strong>" . $row["BookName"]. "</strong>
                      </a>";
              }
            } else {
              echo "<p class='error-message'>Vypadá to, že na burze zrovna žádné takové inzeráty nejsou. Chceš to napravit a <a href='new.html'>přidat inzerát</a>?</p>";
            }
            
            $conn->close();
            exit();
          }
         }
         if ($result->num_rows > 0) {
           while($row = $result->fetch_assoc()) {
             echo "<a href='ad.php?URL=". $row["URL"] ."' class='list-block'>
             <div id='img-wrapper'><img src=" . $row["PhotoURL"]. " alt='Ilustrace učebnice'/></div>
             <strong>" . $row["BookName"]. "</strong>
             </a>";
           }
         } else {
           echo "<p class='error-message'>Vypadá to, že na burze zrovna žádné takové inzeráty nejsou. Chceš to napravit a <a href='new.html'>přidat inzerát</a>?</p>";
         }
      } else {
        $sql = "SELECT URL, BookName, PhotoURL, Price, IsGroup FROM main ORDER BY IsGroup DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
            echo "<a href='ad.php?URL=". $row["URL"] ."' class='list-block'>
                    <div id='img-wrapper'><img src=" . $row["PhotoURL"]. " alt='Ilustrace učebnice'/></div>
                    <strong>" . $row["BookName"]. "</strong>
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
      <p>© Ucebnicovka.cz 2019</p>
    </footer>
  </body>
</html>
