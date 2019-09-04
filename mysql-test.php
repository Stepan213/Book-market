<?php
//Hide all errors to user - file is public
error_reporting(0);
ini_set('display_errors', 0);

// MySQL credentials
include 'php-chunks/mysql-credentials.php';

// Connect to MySQL
$conn = new mysqli($servername, $username, $dbpassword, $dbname);

/* check connection */
if ($conn->connect_errno) {
    echo "<p class='error-message'>Test selhal - nelze se připojit do MySQL</p>";
    exit();
}

$sql = "SELECT LongerD FROM subjects WHERE Base='zsv'";
if(!$result = $conn->query($sql)) {
  die("<p class='error-message'>Test selhal - MySQL dotaz nelze provést. Tabulka buď neexistuje, nebo není správně nakonfigurovaná.</p>");
}
$row = $result->fetch_assoc();

if(!$row["LongerD"] == "základy společenských věd") {
  echo "<p class='error-message'>Test selhal - řetězce se neshodují</p>." . $row["LongerD"] . ".";
}

echo "Konec testu. Test proběhl úspěšně, pokud se nezobrazila žádná jiná zpráva.";

$conn->close();
?>
