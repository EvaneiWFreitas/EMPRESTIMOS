<?php
    require_once "./config/APP.php";
    require_once "./controlador/vistasControlador.php";

    $plantilha = new vistasControlador();
    $plantilha->obter_plantilha_controlador();