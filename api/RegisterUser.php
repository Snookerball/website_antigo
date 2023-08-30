<?php

$servername = "localhost";
$username = "hlfgpaqf_snooker";
$password = "Snooker2023";
$database = "hlfgpaqf_snookerball";

$loginNome = $_GET["loginNome"];
$loginSenha = $_GET["loginSenha"];
$loginEmail = $_GET["loginEmail"];

$conn =  new mysqli($servername, $username, $password, $database);

if($conn->connect_error){
    die("A conexão falhou: ". $conn->connect_error);
}

$sql = "SELECT email FROM usuarios WHERE email = '" . $loginEmail . "'";

$result = $conn->query($sql);

if($result->num_rows > 0){
   echo "Usuário já está em uso.";
}else{
    //echo "Criando usuário...";

    $sql2 = "INSERT INTO usuarios (nome,senha,email,level,coins) VALUES ('".$loginNome."','".$loginSenha."','".$loginEmail."', 1, 0)";
    if($conn->query($sql2) == TRUE){
        //echo "Usuário criado com sucesso!";
        echo 0;
    }else{
        echo "Error:" .$sql2. "<br>" . $conn->error;
    }
}
$conn->close();

?>