<?php

$servername = "localhost";
$username = "hlfgpaqf_snooker";
$password = "Snooker2023";
$database = "hlfgpaqf_snookerball";

$conn =  new mysqli($servername, $username, $password, $database);

$email = $_GET['email'];

if($conn->connect_error){
    die("A conex���o falhou: ". $conn->connect_error);
}
//echo "Conectado com sucesso <br>";

$sql = "SELECT * FROM usuarios WHERE email = '" . $email . "'";

$result = $conn->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        echo "" .$row["nome"]."," .$row["level"]. "," .$row["coins"] ."," .$row["id"]. "," .$row["picture"]."";
    }
}else{
    echo "0 resultados";
}
$conn->close();

?>