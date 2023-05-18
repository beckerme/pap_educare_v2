<?php 
session_start();

if(!$_SESSION['login']){
    header('Location: aviso.php');
}

require_once "../connection/conn.php";

$idAluno = $_SESSION['ID'];
$sql = "SELECT * FROM aulas WHERE id_aluno =".$idAluno."";
$resultado = mysqli_query($connect, $sql);

if(isset($_GET['id_aula'])){
    $_SESSION['id_aula_excluir'] = $_GET['id_aula'];
    header('Location: confirmarExclusao.php');
    exit;
}


?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://kit.fontawesome.com/63de180a8f.js" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
    <h1>Anular agendamento</h1>
    <table style="width: 50%; border: solid 1px black;">
	<tbody>
		<tr>
			<td><b>Data</b></td>
			<td><b>Horário</b></td>
			<td><b>Disciplina</b></td>
			<td><b>Alterações</b></td>
		</tr>
		<?php 
		while($dados = mysqli_fetch_array($resultado)){ ?>
		<tr>
			<td><?php echo $dados['data_aula']; ?></td>
			<td><?php echo $dados['horario_aula']; ?></td>
			<td><?php echo $dados['nome_disciplina']?></td>
			<td>
				<!-- <a href=""><i class="fa-solid fa-magnifying-glass"></i></a> -->
				<a href=""><i class="fa-solid fa-file-arrow-down"></i></a>
				<a href="../settings/anularAgendamento.php?id=<?php echo $dados['id_aula']; ?>"><i class="fa-solid fa-trash"></i></a>
				<button onclick="openPopup()"><i class="fa-solid fa-pen"></i></button>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<div id="meuPopup" style="display: none;">
	<form action="POST" action="../settings/alterarDatas.php"<?php  ?>>
		<input type="date" name="data"  onchange="verificarFimDeSemana()" min="<?php echo date("Y-m-d") ?>">
		<label for="Horas">Horas</label>
		<datalist id="horas">
                <option value="08:00">
                <option value="09:00">
                <option value="10:00">
                <option value="11:00">
                <option value="12:00">
                <option value="13:00">
                <option value="14:00">
                <option value="15:00">
                <option value="16:00">
                <option value="17:00">
                <option value="18:00">
                <option value="19:00">
                <option value="20:00">
                <option value="21:00">
            </datalist>
		<input type="time" name="horario" step="3600" list="horas" id="horario">

		<input type="submit" value="Enviar" name="btn-enviar">
	</form>
	<button onclick="fecharPopup()">Fechar</button>
</div>

<a href="privateArea.php">Voltar</a>

<script src="../../js/script.js"></script>
<script src="teste.js"></script>
</body>
</html>