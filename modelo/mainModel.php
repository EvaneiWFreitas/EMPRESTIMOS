<?php
global $peticaoAjax;
if ($peticaoAjax){
        require_once "../config/SERVER.php";
    }else{
        require_once "./config/SERVER.php";
    }

    class mainModel{
    /*--------- FUNÇÃO DE CONEXÃO COM BASE DE DADOS ----------------*/
        protected static function conectar(){
            $conexao = new PDO(SGBD, USER, PASS);
            $conexao->exec("SET CHARACTER SET utf8");
            return $conexao;
        }
        /*--- FUNÇÃO PARA EXECUTAR CONSULTAS SIMPLES NO BANCO DE DADOS ---*/
        protected static function executar_consultas_simples($consulta){
            $sql=self::conectar()->prepare($consulta);
            $sql->execute();
            return $sql;
        }

        /*--- FUNÇÃO PARA ENCRIPTAR DADOS DE ACESSO AO BD ---*/
        public function encryption($string){
            $output=FALSE;
            $key=hash('sha256', SECRET_KEY);
            $iv=substr(hash('sha256', SECRET_IV), 0, 16);
            $output=openssl_encrypt($string, METHOD, $key, 0, $iv);
            $output=base64_encode($output);
            return $output;
        }
        /*--- FUNÇÃO PARA DESENCRIPTAR DADOS DE ACESSO AO BD ---*/
        protected static function decryption($string){
            $key=hash('sha256', SECRET_KEY);
            $iv=substr(hash('sha256', SECRET_IV), 0, 16);
            $output=openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
            return $output;
        }

        /*--- FUNÇÃO PARA GERAR CÓDIGOS ALEATÓRIOS ---*/
        protected static function gerar_codigos_aleatorios($letra, $longitud, $numero){
            for($i=1; $i<=$longitud; $i++){
                $aleatorio = rand(0,9);
                $letra.= $aleatorio;
            }
            return $letra."-". $numero;
        }

        /*--- FUNÇÃO PARA LIMPAR CADEIAS E SIMBOLOS - PARA ELIMINAR ATAQUES SQL ---*/
        protected  static function limpar_cadeias_e_simbolos($cadeias){
            $cadeias = trim($cadeias);
            $cadeias = stripslashes($cadeias);
            $cadeias = str_ireplace("<script>","",$cadeias);
            $cadeias = str_ireplace("</script>","",$cadeias);
            $cadeias = str_ireplace("<script src","",$cadeias);
            $cadeias = str_ireplace("<script type=","",$cadeias);
            $cadeias = str_ireplace("SELECT * FROM","",$cadeias);
            $cadeias = str_ireplace("DELETE FROM","",$cadeias);
            $cadeias = str_ireplace("INSERT INTO","",$cadeias);
            $cadeias = str_ireplace("DROP TABLE","",$cadeias);
            $cadeias = str_ireplace("DROP DATABASES","",$cadeias);
            $cadeias = str_ireplace("TRUNCATE TABLE","",$cadeias);
            $cadeias = str_ireplace("SHOW TABLE","",$cadeias);
            $cadeias = str_ireplace("SHOW DATABASES","",$cadeias);
            $cadeias = str_ireplace("<?php","",$cadeias);
            $cadeias = str_ireplace("?>","",$cadeias);
            $cadeias = str_ireplace("--","",$cadeias);
            $cadeias = str_ireplace(">","",$cadeias);
            $cadeias = str_ireplace("<","",$cadeias);
            $cadeias = str_ireplace("[","",$cadeias);
            $cadeias = str_ireplace("]","",$cadeias);
            $cadeias = str_ireplace("^","",$cadeias);
            $cadeias = str_ireplace("==","",$cadeias);
            $cadeias = str_ireplace(";","",$cadeias);
            $cadeias = str_ireplace("::","",$cadeias);
            $cadeias = stripslashes($cadeias);
            $cadeias = trim($cadeias);
            return $cadeias;
        }

        /*--- FUNÇÃO PARA VERIFICAR DADOS ---*/
        protected static function verificar_dados($filtro, $cadeiasTexto){
            if(preg_match("/^".$filtro."$/",$cadeiasTexto)){
                return false;
            }else{
                return true;
            }
        }

        /*--- FUNÇÃO PARA VERIFICAR DATAS ---*/
        protected static function verificar_datas($data){
            $valores = explode('-',$data);
            if(count($valores)==3 && checkdate($valores[1],$valores[2],$valores[0])){
                return false;
            }else{
                return true;
            }
        }

        /*--- FUNÇÃO PAGINAÇÃO DE TABELAS ---*/
        protected static function paginador_Tabelas($pagina, $Npaginas, $url, $botoes){
            $tabelas = '<nav aria-label="Page navigation example"><ul class="pagination
            justify-content-center">';

            if($pagina==1){
                $tabelas.='<li class="page-item disabled"><a class="page-link">
                             <i class="fa-solid fa-angles-left"></i></a>
                           </li>';
            }else{
                $tabelas.='
                   <li class="page-item"><a class="page-link" href="'.$url.'1/">
                   <i class="fa-solid fa-angles-left"></i></a></li>
                   <li class="page-item"><a class="page-link" href="'.$url.($pagina-1).
                    '/">Anterior</a></li>
                ';

            }

            $contador_de_iteracao = 0;
            for ($i=$pagina; i<=$Npaginas;$i++){
                if ($contador_de_iteracao>=$botoes){
                    break;
                }

                if ($pagina==$i){
                    $tabelas = '<li class="page-item"><a class="page-link active" 
                    href="'.$url.$i.'1/">'.$i.'</a></li>';
                }else{
                    $tabelas = '<li class="page-item"><a class="page-link" 
                    href="'.$url.$i.'1/">'.$i.'</a></li>';
                }

                $contador_de_iteracao ++;
            }


            if($pagina==$Npaginas){
                $tabelas.='<li class="page-item disabled"><a class="page-link">
                             <i class="fa-solid fa-angles-right"></i></a>
                           </li>';
            }else{
                $tabelas.='
                   <li class="page-item"><a class="page-link" href="'.$url.($pagina+1).
                    '/">Seguinte</a></li>
                   <li class="page-item"><a class="page-link" href="'.$url.$Npaginas.'/">
                   <i class="fa-solid fa-angles-right"></i></a></li>     
                ';
            }

            $tabelas.='</ul></nav>';
            return $tabelas;
        }


    }















