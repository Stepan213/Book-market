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
    //Hide all errors to user
    error_reporting(0);
    ini_set('display_errors', 0);

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
