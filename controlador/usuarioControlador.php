<?php
global $peticaoAjax;
if ($peticaoAjax){
        require_once "../modelo/usuarioModelo.php";
    }else{
        require_once "./modelo/usuarioModelo.php";
    }

    class usuarioControlador extends usuarioModelo{

    }