<?php
@session_start();
require_once("../../conexao.php");
$pag = "depositar";
$query = $pdo->prepare("SELECT * FROM deposito WHERE id_usuario = :id_usuario AND status = 'pendente' ORDER BY id DESC");
$query->bindValue(":id_usuario", $_SESSION['id_usuario']);
$query->execute();
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$output = '';

foreach ($res as $row) {
    $valor = number_format($row['valor'], 2, ',', '.');
    $data = implode('/', array_reverse(explode('-', $row['data'])));

    $output .= "<tr>
    <td>R$ $valor</td>
    <td>$data</td>
    <td>
        <a href='#' class='text-primary mr-1 deposit-edit' title='Editar Dados'
            data-toggle='modal' data-target='#editModal'
            data-id='{$row['id']}' data-valor='{$row['valor']}' data-data='$data'>
            <i class='far fa-edit'></i>
        </a>
    
        <a href='index.php?pag=$pag&funcao=excluir&id={$row['id']}' class='text-danger mr-1' title='Excluir Registro'>
            <i class='far fa-trash-alt'></i>
        </a>
    </td>
</tr>";

}

echo $output;
?>
<script>
    $(document).ready(function() {
    $(".deposit-edit").click(function() {
        var id = $(this).data("id");
        var valor = $(this).data("valor");
        console.log("ID: " + id);
        console.log("Valor: " + valor);
        $("#editId").val(id);
        $("#editValue").val(valor);
    });
    
    
});
</script>
<script>
    $(document).ready(function() {
        $(".deposit-edit").click(function() {
            var value = $(this).data("value");
            $("#editValue").val(value);

            var id = $(this).data("id");
            $("#editId").val(id);
        });

        $("#saveEditBtn").click(function() {
            var idToEdit = $("#editId").val();
            var newValue = $("#editValue").val();
            console.log("ID a ser editado: " + idToEdit);
            console.log("Novo valor: " + newValue);

            // Envie os dados para o PHP para edição no banco de dados
            $.ajax({
                type: "POST",
                url: "deposito/editar_deposito.php", // Coloque o caminho correto para o arquivo PHP
                data: {
                    id: idToEdit,
                    newValue: newValue
                },
                success: function(response) {
                    console.log(response);
                    // Atualize a tabela ou faça outras ações necessárias
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>