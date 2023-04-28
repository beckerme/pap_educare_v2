<?php
require_once '../connection/conn.php';
session_start(); 
if(!$_SESSION['login']){
    header('Location: aviso.php');
}

if(isset($_POST['btn-marcar'])){
    $mensagem = array();
    $data = $_POST['data'];
    $data_format = date('Y-m-d', strtotime($data));
    $horario = $_POST['horario'];
    $idAluno = $_SESSION['ID'];
    $selectDisciplina = $_POST['disciplina'];

    $sql_select = "SELECT id_disciplina FROM disciplina where id_disciplina = ".$selectDisciplina."";
    $query_select = mysqli_query($connect, $sql_select);
    

    $sql = "SELECT DISTINCT id_aluno FROM aulas WHERE id_aluno = (SELECT DISTINCT id_aluno from aulas where id_aluno =".$idAluno.")";
    $resultado = mysqli_query($connect, $sql);

    if(mysqli_num_rows($resultado) == 1)
    {
        $sql = "SELECT * FROM aulas WHERE horario_aula = '$horario'";
        $resulta = mysqli_query($connect, $sql);
        if(mysqli_num_rows($resulta) == 1)
        {
            $mensagem[] = "<li>Já há uma aula agendada neste horário. Por favor tente em um horário diferente.</li>";
        } else if(mysqli_num_rows($query_select)) //colocado comentario depois do else 
        {
            $sql_insert = "INSERT INTO aulas(id_aula, horario_aula, data_aula, id_aluno, nome_disciplina) VALUES(' ', '$horario', '$data_format', '$idAluno', '$selectDisciplina')";
            $result = mysqli_query($connect, $sql_insert);
            $mensagem[] = "<li>Aula registada com sucesso.</li>";
        }
    } elseif(mysqli_num_rows($resultado) <= 0)
        {
           $sql_insert = "INSERT INTO aulas(id_aluno) VALUES('$idAluno')";
           $resu = mysqli_query($connect, $sql_insert);
          if($resu == 1)
          {
                $sql = "SELECT * FROM aulas WHERE horario_aula = '$horario'";
                $resulta = mysqli_query($connect, $sql);
                if(mysqli_num_rows($resulta) == 1)
                {
                    $mensagem[] = "<li>Já há uma aula agendada neste horário. Por favor tente em um horário diferente.</li>";
                } else if(mysqli_num_rows($query_select))
                {
                  $sql_insert = "INSERT INTO aulas(id_aula, horario_aula, data_aula, id_aluno, nome_disciplina) VALUES(' ', '$horario', '$data_format', '$idAluno','$selectDisciplina')";
                   $result = mysqli_query($connect, $sql_insert);
                   $mensagem[] = "<li>Aula registada com sucesso.</li>";
                }
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
            <input type="date" name="data" id="data" onchange="verificarFimDeSemana()">
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
                            echo "<option value = '". $row['id_disciplina']."'>". $row['nome_disciplina'] . "</option>";
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
                    echo $msg;
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