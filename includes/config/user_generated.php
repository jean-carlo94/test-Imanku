
<?php

require "./database.php";
$db = conectarDB();

$name = "Jean Carlo Urrego";
$document = "123456";
$email = "correo@correo.com";
$password = "12345";
$password = password_hash($password,PASSWORD_BCRYPT);

$query = "INSERT INTO coordinator (name, document, email, password) VALUES ('$name','$document','$email','$password')";

$resultado = mysqli_query($db, $query);
?>