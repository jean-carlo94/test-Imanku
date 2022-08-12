
<?php

function conectarDB() : mysqli{
    $db = mysqli_connect('localhost','user','user2015*','elecciones');
    if (!$db) {
        echo "no se conecto";
        exit;
    }
    return $db;
}

?>