
<?php

function conectarDB() : mysqli{
    $db = mysqli_connect('localhost','root','Taziturno1j@1586','elecciones');
    if (!$db) {
        echo "no se conecto";
        exit;
    }
    return $db;
}

?>