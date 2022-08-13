<?php
    require 'includes/config/functions.php';
    $file = $_FILES['file'];

    if(!empty($file['name']) && $file["size"] > 0){
        $folder =__DIR__."/uploads/";    
        if (!is_dir($folder)) {
            mkdir($folder);
        }
        $exten = explode(".",$file['name']);
        $nombrefile = md5(uniqid(rand(),true)).".".$exten[1];

        $upload = move_uploaded_file($file['tmp_name'], $folder.$nombrefile);
        if(!$upload){
            echo "No se pudo cargar archivo";
        }else{
            $info = uploadInfoExcel($folder.$nombrefile);
            echo $info;
        }
    }else{
        echo "No se encontro archivo";
    }
    
?>