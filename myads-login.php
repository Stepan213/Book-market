<!DOCTYPE html>
<html lang="cs/cz" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/master.min.css">
    <title>Moje inzeráty - přihlášení</title>
  </head>
  <body>
    <header>
      <?php include 'php-chunks/header.php' ?>
    </header>
    <h2>Přihlášení k editaci mých inzerátů</h2>
    <p>Pro editaci nebo smazání inzerátů zadej údaje, které jsi zadal/a při přidávání inzerátu.</p>
    <form action="myads.php" method="post">
      <div>
        E-Mail: <input type="email" name="usermail" value="" required><br>
        Heslo: <input type="password" name="password" value="" required><br>
        <input type="submit" name="" value="Přihlásit">
      </div>
    </form>
    <footer>
      <p>© Ucebnicovka.cz 2019</p>
    </footer>
  </body>
</html>
