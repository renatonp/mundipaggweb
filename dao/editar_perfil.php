<?php
// inicia a sessão no site
session_start();
require_once '../model/usuario.php'; // carrega o conteúdo da classe de apoio
$usuariomodel = new UsuarioModel(); // define o objeto da clase UsuarioModel

// seta as variáeis da classe
$usuariomodel->setNome($_POST["nome"]);
$usuariomodel->setEmail($_POST["email"]);
$usuariomodel->setFoto($_FILES["foto"]['name']);
$usuariomodel_email = explode("@", $usuariomodel->getEmail()); // pega o usuário de e-mail do usuário do site
$usuariomodel->setCaminhoFoto($_SERVER["DOCUMENT_ROOT"]."/mundipagg/fotos/".$usuariomodel_email[0]);
$erro=0; // cria e define a vari[avel de controle "erro"

// se senha e confirmarsenha forem iguais, seta a senha do usuário
// se forem diferentes, alerta ao usuário
if($_POST['senha']==$_POST['confirmarsenha']){
    $usuariomodel->setSenha($_POST['senha']);
    $msg="";
}
else{
    $msg="<br />Sua senha n&atilde;o foi alterada pois elas n&atilde;o conferem";
}

$vet = $usuariomodel->alterarDados(); // faz a alteração dos dados

$pasta = $usuariomodel->getCaminhoFoto(); // define o caminho para onde a foto será mandada
$tamanho = 5*1024*1024; // define o tamanho máximo da foto 5MB
$extensoes =  array('jpg', 'png', 'gif'); // define as extensões permitidas para o arquivo
$extensao = explode('.', strtolower($_FILES['foto']['name'])); // pega a extensão do arquivo de upload

// verifica se a extensão do arquivo mandado está coreta e notifica o usuário em caso negativo
if (array_search($extensao[(count($extensao)-1)], $extensoes) === false){
    $msg.="<br />Por favor, envie arquivos com as seguintes extens&otilde;es: jpg, png ou gif";
}

// verifica se o tamanho  do arquivo mandado está coreto e notifica o usuário em caso negativo
if($tamanho < $_FILES['foto']['size']){
    $msg.="<br />O tamanho do arquivo é maior do que 5MB";
}

// se o upload do arquivo não foi feito, alerta ao usuário
// se o upload foi feito, remove o conteúdo atual do diretório
if(!move_uploaded_file($_FILES['foto']['tmp_name'], $pasta.'/'.$_FILES['foto']['name'])){
    $msg.="Falha ao enviar o arquivo";
}

// após completar toda a operação, Notifica ao usuário que seus dados foram alterados
$msg="Dados alterados com sucesso!"; 
echo $msg;
?>
<script>
    window.setTimeout(function() { window.location.replace('../view/editar_perfil.php') }, 5000);
</script>