<?php
//CONFIGURAÇÃO DE ENCRIPTAÇÃO E CONEXÃO COM A BASE DE DADOS.
//PARÂMETROS DE CONEXÃO COM A BASE DE DADOS.
    const SERVER="localhost";
    const DB=" emprestimo";
    const USER="root";
    const PASS="";

    const SGBD="mysql:host=".SERVER.";dbname=".DB;
    const METHOD="AES-256-CBC";
    const SECRET_KEY='$EMPRESTIMOS@2026';
    const SECRET_IV='037970';
