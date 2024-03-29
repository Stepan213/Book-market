<!DOCTYPE html>
<html lang="cs/cz" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/master.min.css">
    <title>Přidání jedné učebnice</title>
  </head>
  <body>
    <header>
      <?php include 'php-chunks/header.php' ?>
    </header>
    <h2>Přidání nového inzerátu</h2>
    <form class="" action="new-single.php" method="post" enctype="multipart/form-data">
      <?php include 'sendform.php' ?>
      <div class="slide">
        <p>Jak se ta učebnice jmenuje?</p>
        <p>(třeba "Základy Programování od Jana Nováka, 2. vydání", název nemusí být přesný)</p>
        Název: <input type="text" name="bookname" value="" required>
      </div>
      <div class="slide">
        <p>O jaký se jedná předmět?</p>
        <select name="subject">
          <option value="aj">Aj</option>
          <option value="cj">Čj</option>
          <option value="nj">Nj</option>
          <option value="fj">Fj</option>
          <option value="fy">Fy</option>
          <option value="ma">Ma</option>
          <option value="ch">Ch</option>
          <option value="de">Dě</option>
          <option value="ze">Ze</option>
          <option value="zsv">ZsV</option>
          <option value="bi">Bi</option>
          <option value="other">Jiné</option>
        </select>
      </div>
      <div class="slide">
        <p>Pro jaký ročník je?</p>
        <select name="schoolyear">
          <option value="1">Prvák</option>
          <option value="2">Druhák</option>
          <option value="3">Třeťák</option>
          <option value="4">Čtvrťák</option>
          <option value="0">Víceleté</option>
        </select>
      </div>
      <div class="slide">
        <p>Jak vypadá?</p>
        <p>(jedna fotka stačí)</p>
        <input type="file" name="fileToUpload" id="fileToUpload" class="inputfile" required/>
        <label for="fileToUpload"><span>Vyber fotku</span></label>
      </div>
      <div class="slide">
        <p>Za kolik?</p>
        Cena: <input type="number" name="price" min="0" required> Kč
      </div>
      <div class="slide">
        <p>Chceš k tomu něco dodat?</p>
        <p>(nech prázdné, pokud ne)</p>
        Poznámka:<br><textarea name="note" value=""></textarea>
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
