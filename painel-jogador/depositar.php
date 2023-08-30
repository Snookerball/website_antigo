<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
@session_start();
if(@$_SESSION['nivel_usuario'] == null || @$_SESSION['nivel_usuario'] != 'jogador'){
	echo "<script language='javascript'> window.location='../index.php' </script>";
}

$pag = "depositar";
require_once("../conexao.php"); 
$query = $pdo->query("SELECT * FROM usuarios where id = '$_SESSION[id_usuario]'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$nome_usu = @$res[0]['nome'];
$email_usu = @$res[0]['email'];
$coins_usu = @$res[0]['coins'];
$level_usu = @$res[0]['level'];

?>

<div class="row mt-4 mb-4">
	<a type="button" class="btn-secondary btn-sm ml-3 d-none d-md-block" data-toggle="modal" data-target="#walletModal" href="#">Novo depósito</a>
	<a type="button" class="btn-primary btn-sm ml-3 d-block d-sm-none" data-toggle="modal" data-target="#walletModal" href="#">+</a>
</div>



<!-- DataTales Example -->
<div id="tabela-depositos">
<div class="card shadow mb-4 bg-dark">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Depósito</th>
                        <th>Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>

            </table>
        </div>
    </div>
</div>
</div>

<!-- Modal for payments and wallet process -->
<div class="modal fade" id="walletModal" tabindex="-1" role="dialog" aria-labelledby="walletModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content bg-dark">
      <div class="modal-header">
        <h5 class="modal-title" id="walletModalLabel"><i class="fa fa-wallet" style="color: #ffffff;"></i> Carteira</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <!-- Conteúdo do modal aqui -->
            <p class="text-center font-weight-bold" style="font-size: 17px;">Escolha o seu método de pagamento</p>
            
            <div class="d-flex justify-content-between align-items-center bg-dark p-2 rounded">
                <a href="#" class="btn btn-dark rounded-pill">Depósito</a>
                <span class="cursor-pointer" style="color: aliceblue;">Retirar</span>
                <span class="cursor-pointer">Verificar documentos</span>
            </div>
            
            <div class="mt-3 d-flex justify-content-between">
                <a href="#" class="btn btn-danger btn-sm deposit-value" data-value="10">R$ 10</a>
                <a href="#" class="btn btn-danger btn-sm deposit-value" data-value="50">R$ 50</a>
                <a href="#" class="btn btn-danger btn-sm deposit-value" data-value="100">R$ 100</a>
            </div>
            
            <div class="mt-3 bg-dark p-2 rounded d-flex">
                <label class="col-auto mr-2 mb-0">Quantia R$</label>
                <input type="text" class="form-control form-control-sm bg-dark col" id="value-to-deposit">
            </div>
            
            <div class="d-flex justify-content-between mt-3">
                <span class="bg-dark p-2 rounded">PIX</span>
                <img src="../img/logo_pix.png" alt="PIX Logo" width="50" height="50">
            </div>
            
            <div class="text-center mt-3">
            <button type="button" class="btn btn-dark btn-sm mr-2" data-dismiss="modal">Voltar</button>
                <a href="#" class="btn btn-danger btn-sm" id="deposit-btn">Depositar</a>
            </div>
        </div>

    </div>
  </div>
</div>

<!-- Modal para editar -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel"><i class="fa fa-edit" style="color: #ffffff;"></i> Editar Depósito</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Campos para edição -->
                <div class="mt-3 d-flex justify-content-between">
                    <a href="#" class="btn btn-danger btn-sm deposit-edit" data-value="10">R$ 10</a>
                    <a href="#" class="btn btn-danger btn-sm deposit-edit" data-value="50">R$ 50</a>
                    <a href="#" class="btn btn-danger btn-sm deposit-edit" data-value="100">R$ 100</a>
                </div>
                <div class="mt-3 bg-dark p-2 rounded d-flex">
                    <label class="col-auto mr-2 mb-0">Quantia R$</label>
                    <input type="text" class="form-control form-control-sm bg-dark col" id="editValue">
                    <input type="text" id="editId" hidden>
                </div>
                <!-- Botão para salvar edição -->
                <button type="button" class="btn btn-danger btn-sm" id="saveEditBtn">Salvar Edição</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $(".deposit-value").click(function() {
        var value = $(this).data("value");
        $("#value-to-deposit").val(value);
    });

    $("#deposit-btn").click(function() {
        var valueToDeposit = $("#value-to-deposit").val();

        if (valueToDeposit !== "") {
            $.ajax({
                type: "POST",
                url: "deposito/deposito.php",
                data: { depositValue: valueToDeposit },
                success: function(response) {
                    // Fechar a modal
                    $("#walletModal").modal("hide");

                    // Atualizar a tabela
                    $("#dataTable tbody").load("deposito/listar.php");

                    // Limpar o campo de valor do depósito
                    $("#value-to-deposit").val("");
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        } else {
            alert("Por favor, insira um valor para depositar.");
        }
    });

    // Atualizar a tabela inicialmente
    $("#dataTable tbody").load("deposito/listar.php");
});

</script>



