<?php
require_once("conexao.php");

//CRIAR AUTOMATICAMENTE O USUARIO ADMIN
$query = $pdo->query("SELECT * FROM usuarios where nivel = 'admin'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg == 0){
	$res = $pdo->query("INSERT INTO usuarios SET nome = 'Administrador', email = '$email_adm', senha = '123', nivel = 'admin', level = '100', coins = '100'");	
}
$email = @$_POST['email'];
$query = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE email = :email");
$query->bindParam(':email', $email);
$query->execute();
$emailExists = $query->fetchColumn();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/solid.min.js" integrity="sha512-s6yNeC6faUgveCQocceGXVia7ciAebyTH7hRNazwZa2FHhnxX22qaGeb9d3a8PUKdnoHo3T3bYI/0ZOjmgWkNg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<!------ Include the above in your HEAD tag ---------->

	<meta charset='UTF-8'><meta name="robots" content="noindex"><link rel="shortcut icon" type="image/x-icon" href="//production-assets.codepen.io/assets/favicon/favicon-8ea04875e70c4b0bb41da869e81236e54394d63638a1ef12fa558a4a835f1164.ico" /><link rel="mask-icon" type="" href="//production-assets.codepen.io/assets/favicon/logo-pin-f2d2b6d2c61838f7e76325261b7195c27224080bc099486ddd6dccb469b8e8e6.svg" color="#111" /><link rel="canonical" href="https://codepen.io/frytyler/pen/EGdtg" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css'><script src='https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js'></script>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/login.css">
	<link rel="shortcut icon" href="img/logo-favicon.ico" type="image/x-icon">
	<link rel="icon" href="img/logo-favicon.ico" type="image/x-icon">
	<script src="https://accounts.google.com/gsi/client" async></script>
	<script src="https://unpkg.com/jwt-decode/build/jwt-decode.js"></script>

	<script>
        function handleCredentialResponse(response) {
          const data = jwt_decode(response.credential)
		  console.log(data);

		  fullName.textContent = data.name
		  sub.textContent = data.sub
		  given_name.textContent = data.given_name
		  family_name.textContent = data.family_name
		  email.textContent = data.email
		  verifiedEmail.textContent = data.email_verified
		  locale.textContent = data.locale
		  picture.setAttribute("src", data.picture)
        }
        window.onload = function () {
          google.accounts.id.initialize({
            client_id: "507578751441-pt2tg5jjhnb9b4aheil00td2lug34tc6.apps.googleusercontent.com",
            callback: handleCredentialResponse
          });
          google.accounts.id.renderButton(
            document.getElementById("buttonDiv"),
            { 
				theme: "outline", 
				size: "large",
				width: "300px",
			}  // customization attributes
          );
          google.accounts.id.prompt(); // also display the One Tap dialog

        }
    </script>
</head>
<body style="background-image:url('img/bg_menu.jpg');">
    <div class="login">
		<div align="center">
			<a href="loginAdm.php">
				<img src="img/snookerball-sf4.png" width="300">
			</a>
		</div>
		<form method="post" action="autenticar.php">
			
            
			<div class="gp-login box-shadow">
				<div id="buttonDiv"></div>
				<input type="text" id="fullName" hidden>
				<input type="text" id="sub" hidden>
				<input type="text" id="given_name" hidden>
				<input type="text" id="family_name" hidden>
				<input type="text" id="email" hidden>
				<input type="text" id="verifiedEmail" hidden>
				<input type="text" id="locale" hidden>
				<input type="text" id="picture" hidden>
			</div>
			
		</form>
		<button id="continueButton" 
		class="btn btn-primary mt-3" 
		style="display: none;" 
		onclick="redirectToPanel()">Continuar</button>
	</div>
<script>
    function handleCredentialResponse(response) {
        const data = jwt_decode(response.credential);

        // ...

        // Enviar os dados para o arquivo salvar_google_login.php usando AJAX
        $.ajax({
            type: "POST",
            url: "salvarLoginGoogle.php",
            data: {
                fullName: data.name,
                sub: data.sub,
                given_name: data.given_name,
                family_name: data.family_name,
                email: data.email,
                verifiedEmail: data.email_verified,
                locale: data.locale,
                picture: data.picture
            },
            success: function(response) {
				console.log(response); // Exibir a resposta do servidor no console
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });

		$.ajax({
            type: "POST",
            url: "autenticar.php",
            data: {
                email: data.email
            },
            success: function(response) {
                if (response.exists) {
                    // Email já cadastrado, redirecionar para a pasta "painel-jogador"
                    window.location.href = 'painel-jogador';
                } else {
                    // Email não cadastrado, exibir botão "Continuar"
                    $('#buttonDiv').hide(); // Esconde o botão do Google
                    $('#continueButton').show(); // Exibe o botão "Continuar"
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
	function redirectToPanel() {
            window.location.href = 'painel-jogador';
        }
</script>

</body>
</html>