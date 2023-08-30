<?php

$servername = "localhost";
$username = "hlfgpaqf_snooker";
$password = "Snooker2023";
$database = "hlfgpaqf_snookerball";

$loginEmail = $_GET["loginEmail"];
$loginSenha = $_GET["loginSenha"];

$conn =  new mysqli($servername, $username, $password, $database);

if($conn->connect_error){
    die("A conexão falhou: ". $conn->connect_error);
}

$sql = "SELECT senha FROM usuarios WHERE email = '" . $loginEmail . "'";

$result = $conn->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        if($row["senha"] == $loginSenha){
            //echo "Logado com sucesso";
            echo "0";


        }else{
            echo "Credenciais incorretas";
        }
    }
}else{
    echo "Usuário não existe!";
}
$conn->close();

?>