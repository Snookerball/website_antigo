<?php
require_once("conexao.php");

// Receber os dados do frontend
$fullName = $_POST['fullName'];
$sub = $_POST['sub'];
$given_name = $_POST['given_name'];
$family_name = $_POST['family_name'];
$email = $_POST['email'];
$verifiedEmail = $_POST['verifiedEmail'];
$locale = $_POST['locale'];
$picture = $_POST['picture'];

// Verificar se o email já está cadastrado
$emailQuery = $pdo->prepare("SELECT * FROM google_login WHERE email = :email");
$emailQuery->bindParam(':email', $email);
$emailQuery->execute();

if ($emailQuery->rowCount() > 0) {
    // O email já está cadastrado, redirecionar para a pasta "painel-jogador"
    header("Location: /painel-jogador/");
    exit();
} else {
    // Inserir os dados no banco de dados
    $query = $pdo->prepare("INSERT INTO google_login (full_name, sub, given_name, family_name, email, verified_email, locale, picture) 
                            VALUES (:full_name, :sub, :given_name, :family_name, :email, :verified_email, :locale, :picture)");

    $query->bindParam(':full_name', $fullName);
    $query->bindParam(':sub', $sub);
    $query->bindParam(':given_name', $given_name);
    $query->bindParam(':family_name', $family_name);
    $query->bindParam(':email', $email);
    $query->bindParam(':verified_email', $verifiedEmail);
    $query->bindParam(':locale', $locale);
    $query->bindParam(':picture', $picture);

    if ($query->execute()) {
        // Inserir os dados na tabela usuarios com os valores desejados
        $nivel = "jogador"; // Nível desejado
        $level = 1; // Level desejado
        $coins = 0; // Coins desejadas
        $senha = 123;

        $query2 = $pdo->prepare("INSERT INTO usuarios (nome, email, sub, senha, nivel, level, coins, picture) 
                                VALUES (:nome, :email, :sub, :senha, :nivel, :level, :coins, :picture)");

        $query2->bindParam(':nome', $fullName);
        $query2->bindParam(':email', $email);
        $query2->bindParam(':sub', $sub);
        $query2->bindParam(':senha', $senha);
        $query2->bindParam(':nivel', $nivel);
        $query2->bindParam(':level', $level);
        $query2->bindParam(':coins', $coins);
        $query2->bindParam(':picture', $picture);

        if ($query2->execute()) {
            // Dados inseridos com sucesso, redirecionar para a pasta "painel-jogador"
            header("Location: painel-jogador");
            exit();
        } else {
            // Ocorreu um erro ao inserir os dados na tabela usuarios
            echo "Ocorreu um erro ao salvar os dados.";
        }
    } else {
        // Ocorreu um erro ao inserir os dados na tabela google_login
        echo "Ocorreu um erro ao salvar os dados.";
    }
}
?>