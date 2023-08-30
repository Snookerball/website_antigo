<?php 
/*$log_file = "./my-errors.log";
ini_set("log_errors", 1);
ini_set("error_log", $log_file);

error_log( "Hello, errors!",3,$log_file);*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
@session_start();
if(@$_SESSION['nivel_usuario'] == null || @$_SESSION['nivel_usuario'] != 'jogador'){
    echo "<script language='javascript'> window.location='../index.php' </script>";
}

require_once("../../conexao.php"); 

// Função para calcular a quantidade de moedas com base no valor do depósito
function calcularQuantidadeCoins($valorDeposito) {
    // Substitua essa lógica pela sua lógica real para calcular as moedas
    // Por exemplo, calcular 1 moeda para cada R$1
    return intval($valorDeposito);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['depositValue'])) {
    // Obter os valores do formulário
    $userId = $_SESSION['id_usuario'];
    $valorDeposito = $_POST['depositValue'];
    $valorparaconta = $valorDeposito;
    $dataDeposito = date('Y-m-d H:i:s'); // Data atual
    $status = 'pendente'; // Você pode definir o status inicial aqui
    $coins = calcularQuantidadeCoins($valorDeposito); // Substitua pela lógica real
    
    // Validar e sanitizar o valor do depósito
    if (!is_numeric($valorDeposito) || $valorDeposito <= 0) {
        echo "Valor de depósito inválido.";
        exit;
    }
    $valorDeposito = floatval($valorDeposito);

    // Preparar e executar a consulta SQL para inserir os dados no banco de dados
    $query = $pdo->prepare("INSERT INTO deposito (id_usuario, valor, data, status, coins) VALUES (:id_usuario, :valor, :data, :status, :coins)");
    $query->bindParam(':id_usuario', $userId);
    $query->bindParam(':valor', $valorDeposito, PDO::PARAM_STR);
    $query->bindParam(':data', $dataDeposito);
    $query->bindParam(':status', $status);
    $query->bindParam(':coins', $coins, PDO::PARAM_INT);
    

    $query1 = $pdo->prepare("SELECT * FROM usuarios where id = :userId");
    $query1->bindParam(':userId', $userId);
    $query1->execute();
    $res = $query1->fetchAll(PDO::FETCH_ASSOC);
    $ccc = @$res[0]['coins'];

    $final = intval($ccc);
    $final1 = intval($valorparaconta);
        
    $final2 = $final + $final1;

    $data = [
        //'valor' => $_POST['depositValue'],
        'valor' => $final2,
        'id' => $userId,
    ];
    $query2 = $pdo->prepare("UPDATE usuarios SET coins=:valor WHERE id=:id");
    //$query2->bindParam(':id', $userId);
    //$query2->bindParam(':valor', 100);
    $query2->execute($data);

    
    
    
    try {
        if ($query->execute()) {
            echo "Depósito realizado com sucesso!";
        } else {
            echo "Ocorreu um erro ao processar o depósito.";
        }
    } catch (PDOException $e) {
        echo "Erro na execução da consulta: " . $e->getMessage();
    }
}
?>
