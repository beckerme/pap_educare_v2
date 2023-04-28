<?php
require_once "../connection/conn.php";

if(isset($_GET['id'])){
    $mensagem = array();
    $idAula = $_GET['id'];

    $sql = "DELETE FROM aulas WHERE id_aula = ".$idAula."";
    $resultado = mysqli_query($connect, $sql);

    if($resultado){
        $mensagem[] = "Aula anulada com sucesso.";
    } else {
        $mensagem[] = "Erro ao anular aula: ".mysqli_error($connect);
    }
} else {
    $mensagem[] = "ID da aula não fornecido.";
}

if(!empty($mensagem)){
    foreach($mensagem as $msg){
        echo '<br>'.$msg;
    }
}
?>
