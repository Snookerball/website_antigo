<?php 
require_once("conexao.php");
@session_start();

$email = $_POST['email'];

$query = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");

$query->bindValue(":email", $email);
$query->execute();

$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){

	$_SESSION['id_usuario'] = $res[0]['id'];
	$_SESSION['nome_usuario'] = $res[0]['nome'];
	$_SESSION['nivel_usuario'] = $res[0]['nivel'];

	$nivel = $res[0]['nivel'];

	if($nivel == 'admin'){
		echo "<script language='javascript'> window.location='painel-adm' </script>";
	}

	if($nivel == 'jogador'){
		echo "<script language='javascript'> window.location='painel-jogador' </script>";
	}
	
}else{
	echo "<script language='javascript'> window.alert('Usuário não encontrado com esse email.') </script>";
	echo "<script language='javascript'> window.location='index.php' </script>";	
}
?>
