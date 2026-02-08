<?php


define('ARQUIVO_DADOS', __DIR__ . '/usuarios.txt');
define('MAX_TAMANHO_ARQUIVO', 5242880); 
define('REGISTROS_POR_PAGINA', 10);

function inicializar_arquivo_dados()
{
  if (!file_exists(ARQUIVO_DADOS)) {
    if (!touch(ARQUIVO_DADOS)) {
      throw new Exception("Erro ao criar arquivo de dados. Verifique as permissões.");
    }
  }

  if (filesize(ARQUIVO_DADOS) > MAX_TAMANHO_ARQUIVO) {
    throw new Exception("Arquivo de dados excedeu o tamanho máximo. Contacte o administrador.");
  }
}


function sanitizar($entrada)
{
  return htmlspecialchars(trim($entrada), ENT_QUOTES, 'UTF-8');
}


function validar_nome($nome)
{
  if (empty($nome) || strlen($nome) < 3) {
    return "Nome deve ter pelo menos 3 caracteres!";
  }
  if (strlen($nome) > 100) {
    return "Nome não pode exceder 100 caracteres!";
  }
  return null;
}


function validar_email($email)
{
  if (empty($email)) {
    return "Email é obrigatório!";
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return "Email inválido!";
  }
  if (strlen($email) > 150) {
    return "Email não pode exceder 150 caracteres!";
  }
  return null;
}

function email_existe($email)
{
  if (!file_exists(ARQUIVO_DADOS) || filesize(ARQUIVO_DADOS) == 0) {
    return false;
  }

  $usuarios = @file(ARQUIVO_DADOS, FILE_IGNORE_NEW_LINES);
  if (!is_array($usuarios)) {
    return false;
  }

  foreach ($usuarios as $usuario) {
    if (preg_match('/Email:\s*([\w\.-]+@[\w\.-]+\.\w+)/', $usuario, $matches)) {
      if (strtolower($matches[1]) === strtolower($email)) {
        return true;
      }
    }
  }

  return false;
}

function salvar_usuario($nome, $email)
{
  $dados = "Nome: " . $nome . " | Email: " . $email . "\n";

  if (file_put_contents(ARQUIVO_DADOS, $dados, FILE_APPEND) === false) {
    return "Erro ao salvar dados. Tente novamente.";
  }

  return null;
}


function obter_usuarios_paginados($pagina = 1)
{
  if (!file_exists(ARQUIVO_DADOS) || filesize(ARQUIVO_DADOS) == 0) {
    return [
      'usuarios' => [],
      'pagina_atual' => 1,
      'total_paginas' => 0,
      'total_registros' => 0
    ];
  }

  $usuarios = @file(ARQUIVO_DADOS, FILE_IGNORE_NEW_LINES);
  if (!is_array($usuarios)) {
    return [
      'usuarios' => [],
      'pagina_atual' => 1,
      'total_paginas' => 0,
      'total_registros' => 0
    ];
  }

  $total_registros = count($usuarios);
  $total_paginas = ceil($total_registros / REGISTROS_POR_PAGINA);
  $pagina = max(1, min($pagina, $total_paginas ?: 1));

  $inicio = ($pagina - 1) * REGISTROS_POR_PAGINA;
  $usuarios_pagina = array_slice($usuarios, $inicio, REGISTROS_POR_PAGINA);

  return [
    'usuarios' => $usuarios_pagina,
    'pagina_atual' => $pagina,
    'total_paginas' => $total_paginas,
    'total_registros' => $total_registros
  ];
}
