<?php
$user = "root"; //variavel em PHP usa $
$pass = "@A09a094";
try {
    $dbh = new PDO('mysql:host=localhost;dbname=laboratorio_g', $user, $pass);
    echo "";
} catch (PDOException $e) {
    echo "";
    echo $e;
}
?>