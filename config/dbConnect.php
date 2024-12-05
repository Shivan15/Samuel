<?php
$user = "root"; //variavel em PHP usa $
$pass = "Samuel@0";
try {
    $dbh = new PDO('mysql:host=localhost;dbname=testes', $user, $pass);
    echo "";
} catch (PDOException $e) {
    echo "";
    echo $e;
}
?>