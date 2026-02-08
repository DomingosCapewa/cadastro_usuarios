# Cadastro de Usuário

Um projeto robusto de cadastro de usuários com validação dupla (cliente e servidor), prevenção de emails duplicados e paginação. Desenvolvido como teste prático para vaga de estagiário em desenvolvimento web.

## Funcionalidades

- Formulário com campos Nome e Email
- **Validação dupla**: JavaScript (cliente) + PHP (servidor)
- **Prevenção de emails duplicados** com validação precisa por regex
- **Proteção contra XSS** com escapamento seguro
- Salva dados em arquivo de texto com persistência
- **Paginação** do histórico (10 registros por página)
- Exibição de dados gravados em tempo real
- Responsivo em dispositivos móveis
- Interface limpa e intuitiva
- Tratamento de erros com alerts sem redirecionamento

## Estrutura de Arquivos

| Arquivo        | Descrição                                               |
| -------------- | ------------------------------------------------------- |
| `index.html`   | Página principal com formulário de cadastro             |
| `dados.php`    | Backend para processar e exibir cadastros com paginação |
| `config.php`   | **Centraliza lógica de negócio e validações**           |
| `style.css`    | Estilos CSS responsivos                                 |
| `script.js`    | Validação de formulário no cliente                      |
| `usuarios.txt` | Arquivo de dados (gerado automaticamente)               |
| `.gitignore`   | Arquivos ignorados pelo Git                             |
| `LICENSE`      | Licença do projeto                                      |

## Como Usar

### 1. Clonar o repositório

```bash
git clone https://github.com/<ajustar com o nome titular>/cadastro_usuarios.git
cd cadastro_usuarios
```

### 2. Configurar servidor local

- Coloque os arquivos em `htdocs` (XAMPP) ou similar
- Inicie o Apache/PHP

### 3. Acessar a aplicação

```
http://localhost/desafio_tecnico_cadastro_de_usuarios/
```

### 4. Usar o formulário

- Preencha Nome (mín. 3 caracteres) e Email válido
- Clique em "Enviar"
- Veja seu cadastro no histórico

## Segurança Implementada

- **XSS Prevention**: `json_encode()` em alerts
- **Input Sanitization**: `htmlspecialchars()` em todas as entradas
- **Email Validation**: `filter_var()` + regex preciso
- **Duplicate Prevention**: Busca case-insensitive por regex
- **Error Handling**: Try-catch com mensagens seguras
- **File Limit**: Máximo 5MB para arquivo de dados

## Tecnologias Utilizadas

| Tecnologia               | Uso                                |
| ------------------------ | ---------------------------------- |
| **HTML5**                | Estrutura semântica                |
| **CSS3**                 | Estilização responsiva com flexbox |
| **JavaScript (Vanilla)** | Validação do lado cliente          |
| **PHP 7+**               | Backend e processamento de dados   |
| **Git**                  | Controle de versão                 |

## Validações Implementadas

### No Cliente (JavaScript)

- Campo nome não vazio
- Campo email não vazio
- Nome com mínimo de 3 caracteres
- Email com formato válido (regex)

### No Servidor (PHP)

- Campo nome não vazio (3-100 caracteres)
- Campo email não vazio (até 150 caracteres)
- Email com formato válido (`filter_var`)
- **Email não duplicado** (busca precisa por regex)
- Verificação de permissões de arquivo
- Limite de tamanho máximo

### Config.php (Funções Reutilizáveis)

```php
validar_nome($nome)           // Valida nome
validar_email($email)         // Valida email
email_existe($email)          // Verifica duplicação
salvar_usuario($nome, $email) // Salva com tratamento de erro
obter_usuarios_paginados($p)  // Retorna dados com paginação
sanitizar($entrada)           // Escape de entrada
```

## Tratamento de Erros

- Erros de validação exibem **alert sem redirecionar**
- Usuário permanece na página para corrigir
- Mensagens de erro claras em português
- Logs de erro para debug

## Requisitos de Sistema

- PHP 7.0+
- Servidor web (Apache, Nginx)
- Permissões de escrita no diretório do projeto

## Requisitos do Desafio (Atendidos)

- [x] HTML com título e formulário (nome, email, botão)
- [x] CSS centralizado e responsivo
- [x] JavaScript com validação de campos
- [x] PHP com salvamento em arquivo
- [x] Exibição de dados gravados
- [x] Validação de email duplicado
- [x] Repositório GitHub público
- [x] **Melhorias extras**: Paginação, segurança avançada, config reutilizável

## Autor

**Tainara Manuel** - Desenvolvido como teste prático para vaga de estagiário em desenvolvimento web.

## Licença

Este projeto está sob licença MIT. Veja o arquivo `LICENSE` para mais detalhes.

---

**Última atualização:** Fevereiro 2026  
**Status:** Pronto para produção
