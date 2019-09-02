<!DOCTYPE html>
<html lang="cs/cz" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/master.min.css">
    <title>Přidání nového inzerátu</title>
  </head>
  <body>
    <header>
      <?php include 'php-chunks/header.php' ?>
    </header>
    <h2>Přidání nového inzerátu</h2>
    <form class="" action="sendform.php" method="post" enctype="multipart/form-data">
      <div class="slide">
        <p>Kolik toho bude?</p>
        <p>(Učebnice můžeš přidat buď po jednom, nebo jako skupinu, třeba "Učebnice pro 1. ročník")</p>
        <a href="new-single.php">Jedna učebnice</a>
        <a href="new-group.php">Víc učebnic najednou</a>
      </div>
    </form>
    <footer>
      <p>© Ucebnicovka.cz 2019</p>
    </footer>
  </body>
</html>
