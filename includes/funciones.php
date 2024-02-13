<?php
header('Access-Control-Allow-Origin: *'); //permite acceso a cualquier otro origen

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//funcionque revisa que el usuario este autenticado
function isAuth():bool{
    if (session_status() == PHP_SESSION_NONE) {//verificar que el estatus no ha iniciado
        session_start();
    }
    if(!isset($_SESSION['login'])){
        return false;
    }else{
        return true;
    }
}
//funcionque revisa que el usuario este autenticado
function isAdmin():bool{
    if (session_status() == PHP_SESSION_NONE) {//verificar que el estatus no ha iniciado
        session_start();
    }
    if(!isset($_SESSION['admin'])){
        return false;
    }else{
        return true;
    }
}

function esUltimo(string $actual, string $proximo):bool{
    if($actual !== $proximo) return true;
    return false; 
}