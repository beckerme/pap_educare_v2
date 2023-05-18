<?php
session_start();
require_once "../connection/conn.php";

if(isset($_POST['btn-enviar'])){
    $idAluno = $_SESSION['ID'];
    $sql = "SELECT * FROM aulas WHERE id_aluno = '$idAluno'";
    $res = mysqli_query($connect, $sql);

    if(mysqli_num_rows($res) > 0){
        $sql = "SELECT id_aula, id_aluno, horario_aula, data_aula FROM aulas WHERE id_aluno ='$id_aluno'";
        $res = mysqli_query($connect, $sql);

        if(mysqli_num_rows($res) > 0){
            $sql
        }
    }
}

?>