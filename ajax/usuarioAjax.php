<?php
$peticaoAjax = true;
require_once "../config/APP.php";

    if (false){

        /*--- INSTÂNCIA DO CONTROLADOR ---*/
        require_once "../controlador/usuarioControlador.php";
        $ins_usuario = new usuarioControlador();

    }else{
        session_start(['name'=>'SPM']);
        session_unset();
        session_destroy();
        header("Location: ".SERVERURL."login/");
        exit();
    }