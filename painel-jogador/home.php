<?php
@session_start();
if(@$_SESSION['nivel_usuario'] == null || @$_SESSION['nivel_usuario'] != 'jogador'){
	echo "<script language='javascript'> window.location='../index.php' </script>";
}

require_once("../conexao.php");

$query = $pdo->query("SELECT * FROM usuarios where id = '$_SESSION[id_usuario]'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$userId = @$res[0]['id'];
$nome_usu = @$res[0]['nome'];
$email_usu = @$res[0]['email'];
$coins_usu = @$res[0]['coins'];
$level_usu = @$res[0]['level'];
?>

<div class="row">
    <!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-danger bg-danger shadow h-100 py-2">
			<div class="card-body bg-dark">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Dados</div>
						
						<div class="sidebar-heading">
                            <?php echo $userId; ?>
                        </div>
						<div class="sidebar-heading">
                            <?php echo $nome_usu; ?>
                        </div>
                        <div class="sidebar-heading">
                            <?php echo $email_usu; ?>
                        </div>

						<div class="h5 mb-0 font-weight-bold text-white-800"></div>
					</div>
					<!-- <div class="col-auto">
						<i class="fas fa-dollar-sign fa-2x text-danger"></i>
					</div> -->
				</div>
			</div>
		</div>
	</div>
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-danger bg-danger shadow h-100 py-2">
			<div class="card-body bg-dark">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Saldo na carteira</div>
						<div class="h5 mb-0 font-weight-bold text-white-800"><?php echo $coins_usu ?></div>
					</div>
					<div class="col-auto">
						<img src="../img/coin.png" alt="coin" width="50">
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-danger bg-danger shadow h-100 py-2">
			<div class="card-body bg-dark">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Level</div>
						<div class="h5 mb-0 font-weight-bold text-white-800"><?php echo $level_usu ?></div>
					</div>
					<div class="col-auto">
						<i class="fa fa-bolt fa-2x text-danger"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	
</div>