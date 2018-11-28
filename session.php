<?php

session_start();
if(!isset($_SESSION['id'])){
    $_SESSION['rol']="0";
}else{
    $check_user = User::findById($_SESSION['id']);
    if(!empty($check_user->gebruikersnaam)){
        $row_username = $check_user->gebruikersnaam;
        $row_voornaam = $check_user->voornaam;
        $row_achternaam = $check_user->achternaam;
        $row_rol = $check_user->rol;

        $_SESSION["gebruikersnaam"] = $row_username;
        $_SESSION["voornaam"] = $row_voornaam;
        $_SESSION["achternaam"] = $row_achternaam;
        $_SESSION["rol"] = $row_rol->id;
    }else{
        header("Location:?controller=pages&action=logout");
    }
}

?>