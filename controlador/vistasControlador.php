<?php
    require_once "./modelo/vistasModelo.php";
    class vistasControlador extends vistasModelo{
        /*-----Controlador para obter pantilha-----*/
        //obter_plantilha_controlador = obter_controlador_planta
        public function obter_plantilha_controlador(){
            return require_once "./vistas/plantilha.php";
        }

        /*-----Controlador para obter vistas-----*/
        public function obtener_vistas_controlador(){
            if (isset($_GET['views'])){
                $rota=explode("/",$_GET['views']);
                $resposta=vistasModelo::obtener_vistas_modelo($rota[0]);
            }else{
                $resposta="login";
            }
            return $resposta;
        }


    }