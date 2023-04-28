<?php 
session_start();
require_once "php/connection/conn.php";
if(isset($_POST['btn-login'])){
    $mensagem = array();
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $senha = md5(mysqli_real_escape_string($connect, $_POST['senha']));


    $sql = "SELECT email_aluno FROM alunos WHERE email_aluno = '$email'";
    $resultado = mysqli_query($connect, $sql);
    $row = mysqli_fetch_assoc($resultado);

    if(mysqli_num_rows($resultado) > 0){
        $sql = "SELECT * FROM alunos WHERE email_aluno = '$email' AND senha_aluno = '$senha'";
        $resultado = mysqli_query($connect, $sql);

        if(mysqli_num_rows($resultado) == 1){
            $dados = mysqli_fetch_array($resultado);
            mysqli_close($connect);
            $_SESSION['login'] = true;
            $_SESSION['email'] = $dados['email_aluno'];
            $_SESSION['nome'] = $dados['nome_aluno'];
            $_SESSION['ID'] = $dados['id_aluno'];

            header('Location: php/pages/privateArea.php');
        } else {
            $mensagem[] = "<li> Usuário e senha não conferem</li>";
        }
    } else {
        $mensagem[] = "<li>Usuario inexistente</li>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <title>Document</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'PT Sans', sans-serif;
        }

        /* Estilo para o formulário */
        form {
        width: 40%;
        margin: 0 auto;
        padding: 20px;
        background-color: #f0f0f0;
        border-radius: 10px;
        box-shadow: 0px 10px 20px rgb(0 0 0 / 20%);
        display: flex;
        flex-direction: column;
        align-items: center;
        }

        /* Estilo para os campos de entrada */
        label, input, textarea {
        display: block;
        margin-bottom: 15px;
        }

        label {
        font-weight: bold;
        font-size: 1.2rem;
        }

        input {
        padding: 10px;
        width: 50%;
        border: none;
        border-radius: 5px;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
        font-size: 1.1rem;
        }

        textarea {
        height: 150px;
        }

        /* Estilo para o botão de envio */
        .enviar {
        background-color: #0066cc;
        color: #fff;
        font-weight: bold;
        padding: 12px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-size: 1.2rem;
        }

        .enviar:hover {
        background-color: #0052a3;
        }

        /* Estilo para o título do formulário */
        h1 {
        font-size: 2.5rem;
        text-align: center;
        margin-bottom: 30px;
        }

        /* Estilo para campos menores */
        @media (max-width: 767px) {
        input, textarea {
            width: 95%;
            font-size: 1rem;
            padding: 8px;
        }
        }
    </style>
</head>
<body>
    <h1>Formulário de Login</h1>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">

      <label for="email">Email:</label>
      <input type="email" name="email" required>

      <label for="mensagem">Senha:</label>
      <input type="password" name="senha" required>

      <button type="submit" class="enviar" name="btn-login">Login</button><br>
      <a href="php/pages/registo.php">Se não tiver uma conta, registe-se aqui.</a>

      <?php 
        if(!empty($mensagem)){
            foreach($mensagem as $msg){
                echo $msg;
            }
        }
      ?>
    </form>
</body>
</html>