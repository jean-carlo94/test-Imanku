<?php
require 'database.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
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

