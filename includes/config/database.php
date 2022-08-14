
<?php

function conectarDB() : mysqli{
    $db = mysqli_connect('localhost','root','clave','elecciones');
    if (!$db) {
        echo "no se conecto";
        exit;
    }
    return $db;
}

?>
