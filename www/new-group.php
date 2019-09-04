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
    <form class="" action="new-group.php?group=1" method="post" enctype="multipart/form-data">
      <?php include 'sendform.php' ?>
      <div class="slide">
        <p>Jak se to dá souhrně nazvat?</p>
        <p>(třeba "Učebnice češtiny pro prvák")</p>
        Název: <input type="text" name="bookname" value="" required>
      </div>
      <div class="slide">
        <p>Pro jaký ročník jsou?</p>
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
      <?php include 'php-chunks/new-ad-javascript.php' ?>
    </script>
  </body>
</html>
