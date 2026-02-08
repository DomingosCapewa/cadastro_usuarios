<?php
session_start();
require_once 'config.php';

try {
    inicializar_arquivo_dados();
} catch (Exception $e) {
    die("Erro: " . htmlspecialchars($e->getMessage()));
}

$erro = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $nome = sanitizar($_POST['nome'] ?? '');
   $email = sanitizar($_POST['email'] ?? '');

   $erro = validar_nome($nome);
   if (!$erro) {
      $erro = validar_email($email);
   }
   
   if (!$erro && email_existe($email)) {
      $erro = "Este email já foi cadastrado!";
   }
   
   if (!$erro) {
      $erro = salvar_usuario($nome, $email);
      
      if (!$erro) {
         $_SESSION['ultimo_nome'] = $nome;
         $_SESSION['ultimo_email'] = $email;
         header("Location: " . $_SERVER['PHP_SELF']);
         exit;
      }
   }
}
      

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Histórico de Cadastros </title>
   <link rel="stylesheet" href="style.css">
</head>

<body>
   <h1>Histórico de Cadastros</h1>

   <?php if ($erro): ?>
      <script>
         alert(<?php echo json_encode($erro, JSON_UNESCAPED_UNICODE); ?>);
      </script>
   <?php endif; ?>

   <div class="box">
      <?php if (isset($_SESSION['ultimo_nome'])): ?>
         <div class="sucesso">
            <h3>Seus dados foram salvos com sucesso!</h3>
            <p><strong>Nome:</strong> <?php echo $_SESSION['ultimo_nome']; ?></p>
            <p><strong>Email:</strong> <?php echo $_SESSION['ultimo_email']; ?></p>
         </div>
         <?php unset($_SESSION['ultimo_nome'], $_SESSION['ultimo_email']); ?>
      <?php endif; ?>
   </div>

   <div class="box" style="margin-top: 20px;">
      <h3>Histórico de Cadastros:</h3>
      <?php
      $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
      $dados = obter_usuarios_paginados($pagina);
      
      if (!empty($dados['usuarios'])) {
         echo "<ul style='color: salmon; margin-left: 20px;'>";
         foreach ($dados['usuarios'] as $usuario) {
            echo "<li>" . htmlspecialchars($usuario) . "</li>";
         }
         echo "</ul>";
         
         if ($dados['total_paginas'] > 1) {
            echo "<div style='margin-top: 15px; text-align: center; color: salmon;'>";
            
            if ($dados['pagina_atual'] > 1) {
               echo "<a href='?pagina=" . ($dados['pagina_atual'] - 1) . "' style='color: salmon; margin-right: 10px;'>← Anterior</a>";
            }
            
            echo "Página <strong>" . $dados['pagina_atual'] . "</strong> de <strong>" . $dados['total_paginas'] . "</strong>";
            
            if ($dados['pagina_atual'] < $dados['total_paginas']) {
               echo "<a href='?pagina=" . ($dados['pagina_atual'] + 1) . "' style='color: salmon; margin-left: 10px;'>Próxima →</a>";
            }
            
            echo "</div>";
         }
      } else {
         echo "<p style='color: salmon;'>Nenhum cadastro ainda.</p>";
      }
      ?>
      <button style="justify-content: center;"><a href="index.html">Voltar para o formulário</a></button>
   </div>

   <script src="script.js"></script>
</body>

</html>