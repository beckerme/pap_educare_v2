<?php
require_once "../connection/conn.php";

if (isset($_GET['id'])) {
    $idAula = $_GET['id'];
} else {
    echo "ID da aula não fornecido.";
    exit;
}

// Consultar a aula com base no ID fornecido
$sql = "SELECT * FROM aulas WHERE id_aula = " . $idAula;
$resultado = mysqli_query($connect, $sql);

if (mysqli_num_rows($resultado) == 0) {
    echo "Aula não encontrada.";
    exit;
}

// Extrair os dados da aula do resultado da consulta
$aula = mysqli_fetch_assoc($resultado);

// Verificar se o formulário foi submetido
if (isset($_POST['btn-marcar'])) {
    $novaData = $_POST['nova_data'];
    $novoHorario = $_POST['novo_horario'];

    // Verificar se já existe uma aula agendada para a nova data e horário
    $sqlVerificar = "SELECT * FROM aulas WHERE data_aula = '$novaData' AND horario_aula = '$novoHorario'";
    $resultadoVerificar = mysqli_query($connect, $sqlVerificar);

if (mysqli_num_rows($resultadoVerificar) > 0) {
    echo "Já existe uma aula marcada para esta data e horário.";
    exit;
}

    // Atualizar a data e o horário da aula no banco de dados
    $sqlUpdate = "UPDATE aulas SET data_aula = '$novaData', horario_aula = '$novoHorario' WHERE id_aula = " . $idAula;
    $resultadoUpdate = mysqli_query($connect, $sqlUpdate);

if ($resultadoUpdate) {
    echo "Aula alterada com sucesso.";
} else {
    echo "Erro ao alterar aula: " . mysqli_error($connect);
}
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Aula</title>
</head>
<body>
    <h1>Alterar aula</h1>

    <form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $idAula; ?>" method="POST">
        <label>Nova Data:</label>
        <input type="date" name="nova_data" id="data" value="<?php echo $aula['data_aula']; ?>" onchange="verificarFimDeSemana()" min="<?php echo date("Y-m-d") ?>">
        <br><br>
        <label>Novo Horário:</label>
        <input type="time" name="novo_horario" step="3600" list="horas" id="horario" value="<?php echo $aula['horario_aula']; ?>">
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
        <br><br>
        <button type="submit" name="btn-marcar" id="btnMarcar">Alterar Aula</button>
    </form>
    <span id="msgErro" style="color: red; display: none;">Horários indisponíveis nos finais de semana.</span>

    <a href="../pages/anularAgendamento.php">Voltar</a>
    <script src="../pages/teste.js"></script>
</body>
</html>
