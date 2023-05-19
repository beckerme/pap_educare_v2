<?php
require_once '../connection/conn.php';
session_start(); 
if(!$_SESSION['login']){
    header('Location: aviso.php');
}

if(isset($_POST['btn-marcar'])) {
    $mensagem = array();
    $horario = $_POST['horario'];
    $data = date('Y-m-d', strtotime($_POST['data']));
    $disciplina = $_POST['disciplina'];
    $aluno = $_SESSION['ID'];

    
    // Verificar se já existe uma aula marcada para a mesma disciplina e data
    // $sql = "SELECT * FROM aulas WHERE horario_aula='$horario' AND data_aula='$data' AND nome_disciplina='$disciplina'";
    $sql = "SELECT * FROM aulas WHERE id_aluno='$aluno' AND horario_aula='$horario' AND data_aula='$data' OR horario_aula='$horario' AND data_aula='$data' AND nome_disciplina='$disciplina'";
    $result = mysqli_query($connect, $sql);

   if (mysqli_num_rows($result) > 0) {
        $mensagem[] = "Já existe uma aula marcada para esta disciplina nesta data e horario.";

    } else {

      // Inserir os dados na tabela de aulas
      $sql = "INSERT INTO aulas (horario_aula, data_aula , id_aluno, nome_disciplina) VALUES ('$horario', '$data', '$aluno', '$disciplina')";
      if (mysqli_query($connect, $sql)) {
        $mensagem[] = "Aula marcada com sucesso.";
      } else {
        $mensagem[] = "Erro ao marcar aula: " . mysqli_error($connect);
      }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Bem vindo(a) <?php echo $_SESSION['nome']; ?> à sua área privada!</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <fieldset>
            <legend>Marcar aulas</legend>

            <label>Data:</label>
            <input type="date" name="data" id="data" onchange="verificarFimDeSemana()" min="<?php echo date("Y-m-d") ?>">
            <br><br>
            <label>Horario</label>
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
            <select name="disciplina">
                <?php
                    $sql_disciplina = "SELECT * FROM disciplina";
                    $res = mysqli_query($connect, $sql_disciplina);
                    
                    if(mysqli_num_rows($res) > 0){
                        while($row = mysqli_fetch_assoc($res)){
                            echo "<option value = '". $row['nome_disciplina']."'>". $row['nome_disciplina'] . "</option>";
                        }
                    } else {
                        echo "0 results";
                    }
                ?>
            </select>
            <button type="submit" name="btn-marcar" id="btnMarcar">Marcar aulas</button>
            <span id="msgErro" style="color: red; display: none;">Horários indisponíveis nos finais de semana.
            </span>
            <?php
            if(!empty($mensagem)){
                foreach($mensagem as $msg){
                    echo '<br>'.$msg;
                }
            }
            ?>
        </fieldset>

        <a href="anularAgendamento.php">Anular agendamento</a>
    </form>

    <button type="submit"><a href="logout.php">SAIR</a></button>
    <script src="teste.js"></script>
</body>
</html>