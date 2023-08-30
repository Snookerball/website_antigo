<?php

$servername = "localhost";
$username = "hlfgpaqf_snooker";
$password = "Snooker2023";
$database = "hlfgpaqf_snookerball";

$conn =  new mysqli($servername, $username, $password, $database);

$email = $_GET['email'];
$coins = $_GET['coins'];

if($conn->connect_error){
    die("A conex���o falhou: ". $conn->connect_error);
}
echo "Conectado com sucesso <br>";

$sql = "UPDATE usuarios SET coins = " . $coins . " WHERE email = '" . $email . "'";

if (mysqli_query($conn, $sql)) {
  echo "Record updated successfully";
} else {
  echo "Error updating record: " . mysqli_error($conn);
}

$conn->close();

?>