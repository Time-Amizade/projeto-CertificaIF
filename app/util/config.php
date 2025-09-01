<?php
#Nome do arquivo: config.php
#Objetivo: define constantes para serem utilizadas no projeto

//Mostrar erros do PHP
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Banco de dados: conexão MySQL
define('DB_HOST', 'localhost');
define('DB_NAME', 'db_certifica');
define('DB_USER', 'root');  
define('DB_PASSWORD', 'bancodedados');

//Caminho para adionar imagens, scripts e chamar páginas no sistema
//Deve ter o nome da pasta do projeto no servidor APACHE
define('BASEURL', '/projeto-CertificaIF/app');

//Nome do sistema
define('APP_NAME', 'CertificaIF');

//Página de listagem de cursos do sistema
define('CURSO_PAGE', BASEURL . '/controller/CursoController.php?action=list');

//Página de logout do sistema
define('LOGIN_PAGE', BASEURL . '/controller/LoginController.php?action=login');

//Página de login do sistema
define('LOGOUT_PAGE', BASEURL . '/controller/LoginController.php?action=logout');

//Página home do sistema
define('HOME_PAGE', BASEURL . '/controller/HomeController.php?action=home');

//Sessão do usuário
define('SESSAO_USUARIO_ID', "usuarioLogadoId");
define('SESSAO_USUARIO_NOME', "usuarioLogadoNome");
define('SESSAO_USUARIO_PAPEL', "usuarioLogadoPapel");
define('SESSAO_USUARIO_CURSO', "usuarioLogadoCurso");

//Arquivos
define('PATH_ARQUIVOS', __DIR__ . "/../../arquivos");
define('BASEURL_ARQUIVOS', BASEURL . "/../arquivos");


