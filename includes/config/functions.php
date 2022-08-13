<?php
require 'database.php';
require '/var/www/html/test-Imanku/vendor/autoload.php';
use \PhpOffice\PhpSpreadsheet\IOFactory;

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_REQUEST['f'])){
    $rta = '';
    $ev="\$rta={$_REQUEST['f']}();";
    if (function_exists("{$_REQUEST['f']}")){
        eval($ev);
        echo json_encode($rta);
    }else{
        echo json_encode($_POST);
    }
}
function estAuth() : bool {
    session_start();
    $auth = $_SESSION['login'];
    if($auth){
        return true;
    }
    return false;
}
function login(): string{
    $db = conectarDB();
    $email = mysqli_real_escape_string($db, filter_var($_POST['email'],FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']); 

    $state = ($email && $password ? '':'Sin Datos');

    if(empty($state)){
        $query = "SELECT * FROM coordinator WHERE email = '$email'";
        $resultado = mysqli_query($db, $query);
       
        if($resultado->num_rows){
            $usuario = mysqli_fetch_assoc($resultado);
            $auth = password_verify($password, $usuario['password']);
            if($auth){
                session_start();
                $_SESSION['usuario']=$usuario['email'];
                $_SESSION['login']=true; 
                $state =  "form-election.php";
            }else{
                $state="Password Invalido";
            }
        }else{
            $state="Usuario No encontrado";
        }
    }
    return $state;
}
function addvotes(): string{
    $db = conectarDB();
    $rta ="";
    $query = "INSERT INTO election (year,voteCount,poloticalParty,countty_id) VALUES ('{$_POST['year']}','{$_POST['votes']}','{$_POST['party']}',{$_POST['contry']})";
    $result = mysqli_query($db,$query);
    if($result){
        $rta = "Votos ingresados correctamente";
    }else{
        $rta = "Error ingresando Vostos";
    }   
    return $rta;
}
function uploadInfoExcel($file): string{
    $rta = "";
    $documento = IOFactory::load($file);
    $hoja = $documento->getSheet(0);
    $filas = $hoja->getHighestRow();
    $columnas = $hoja->getHighestColumn();
    $columnas = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($columnas);

    $db = conectarDB();
    for ($i = 2; $i <= $filas; $i++) {
        $query = "";
        $query = "SELECT id FROM estates WHERE estate = '{$hoja->getCellByColumnAndRow(1, $i)}'";
        $resultado = mysqli_query($db, $query);
        
        if($resultado->num_rows===0){
            $query = "INSERT INTO estates (estate) VALUES ('{$hoja->getCellByColumnAndRow(1, $i)}')";
            $result = mysqli_query($db,$query);
            if($result){
                $query = "SELECT id FROM estates WHERE estate = '{$hoja->getCellByColumnAndRow(1, $i)}'";
                $resultado = mysqli_query($db, $query);
            }
        }
        $estate = mysqli_fetch_assoc($resultado);
        $estate = $estate['id'];
        $codecounty = preg_replace('([^A-Za-z0-9])','',$hoja->getCellByColumnAndRow(2, $i));
        $county = preg_replace('([^A-Za-z0-9])','',$hoja->getCellByColumnAndRow(3, $i));
        $population = preg_replace('([^0-9])','',$hoja->getCellByColumnAndRow(4, $i));
        $population = ($population === ''?0:$population);
        $area = explode('.',$hoja->getCellByColumnAndRow(5, $i));
        $area =$area[0].".".substr($area[1],0,2); 

        $query = "SELECT * FROM countty WHERE codeCounty = '$codecounty' AND county = '$county' AND population = $population AND area = $area AND estates_id = $estate";
        $resultado = mysqli_query($db, $query);

        if($resultado->num_rows===0){
            $query = "INSERT INTO countty (codeCounty,county,population,area,estates_id) VALUES ('$codecounty','$county','$population','$area','$estate')";
            $result = mysqli_query($db,$query);
            if($result){
                $rta = "Carga Correcta";
            }
        }else{
            $rta = "La informacion Ya fue cargada";
        }

    }
    return $rta;
}

function uploadInfoJson($file): string{
    $db = conectarDB();
    $info = file_get_contents($file);
    $info = json_decode($info);

    for ($i=0; $i < count($info) ; $i++) { 
        $query = "SELECT id FROM countty WHERE codeCounty = '{$info[$i]->codecounty}'";
        $county = mysqli_fetch_assoc(mysqli_query($db, $query))['id'];

        foreach ($info[$i] as $key => $value){
            if($key != 'year' && $key != 'codecounty'){
                $query = "INSERT INTO election (year,voteCount,poloticalParty,countty_id) VALUES ('{$info[$i]->year}','{$value}','{$key}',$county)";
                $result = mysqli_query($db, $query);
                if($result){
                    $rta = "Votos ingresados correctamente";
                }else{
                    exit;
                };
            }
        }
    }
    return $rta;
}
