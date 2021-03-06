<?php
session_start();
if(isset($_SESSION["usuario"])){
    require_once '../model/usuario.php';
    $usuariomodel = new UsuarioModel();
    $usuariomodel->setEmail($_SESSION['usuario']);
    $vet = $usuariomodel->carregarDados();
    if($vet['linhas'] > 0){
        while($resultado = $vet["sql"]->fetch(PDO::FETCH_ASSOC)){
            $usuariomodel->setNome($resultado["nome"]);
            $usuariomodel->setEmail($resultado["email"]);
        }
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <style type="text/css">
            nav{
                position: absolute;
                left: 40%;
            }
            #cadastro{
                position: absolute;
                left: 40%;
                top:50px;
            }
        </style>
    </head>    
    <body>
        <?php require_once '../plugin/menu.php'; ?>
        <div id="cadastro" align="center">
            <form action="../dao/editar_perfil.php" method="post"  enctype="multipart/form-data">
                Nome: <input type="text" name="nome" id="nome" value="<?=$usuariomodel->getNome()?>"><br />
                E-mail: <input type="text" name="email" id="email" value="<?=$usuariomodel->getEmail()?>"><br />
                Senha: <input type="password" name="senha" id="senha"><br />
                Confirmar Senha: <input type="password" name="confirmarsenha" id="confirmarsenha"><br />
                Foto: <input type="file" name="foto" id="foto"><br />
                <input type="submit" id="botao_enviar" value="Alterar Dados" />
            </form>
            <div id="msg"></div>
        </div>
    </body>
</html>
<?php
}
else{
    echo"N&atilde;o foi feito ligin no site! <a href='../index.php'>voltar</a>";
}
?>