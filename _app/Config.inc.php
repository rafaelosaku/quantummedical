<?php

// CONFIGURAÇÕES DO SITE #############################
define('HOME', 'http://localhost/Projetos/quantummedical');
define('THEME', 'quantummedical');
define('INCLUDE_PATH', HOME . '/' . 'themes' . '/' . THEME);
define('REQUIRE_PATH', 'themes' . DIRECTORY_SEPARATOR . THEME);

// CONFIGURAÇÕES DO BANCO ############################
define('HOST', 'localhost');
define('USER', '');
define('PASS', '');
define('DBSA', '');

// DEFINE SERVIDOR DE E-MAIL PARA TESTE ##############
define('MAILUSER', 'contato@quantummedical.com.br');
define('MAILPASS', 'spfc@1234');
define('MAILPORT', '465');
define('MAILHOST', 'server1.rapidcloud.com.br');

// DEFINE IDENTIDADE DO SITE #########################
define('SITENAME', 'Quantum Medical');
define('SITEDESC', 'Quantum Medical');



/**
 * ================================================ *
 * DEFINE META TAGS                                 *
 * ================================================ *
 */
$pg_name = SITENAME;
$pg_site = 'Quantum Medical';
$pg_google_author = '114416679358029603173';
$pg_google_publisher = '114416679358029603173';
/* Facebook */
$pg_fb_app = "1504030069919043";
$pg_fb_author = "rafael.osaku";
$pg_fb_page = "";
/* Twitter */
$pg_twitter = '';
$pg_domain = 'quantummedical.com.br';
/* GOOGLE */
define('PG_GOOGLE_AUTHOR', '114416679358029603173');
define('PG_GOOGLE_PUBLISHER', '114416679358029603173');
define('PG_SITEKIT', INCLUDE_PATH . 'images/sitekit/');

/* FACEBOOK */
define('PG_FB_APP', '1504030069919043');
define('PG_FB_AUTHOR', 'rafael.osaku');
define('PG_FB_PAGE', "https://www.facebook.com/quantumlocacoes/?fref=ts");

/* Twitter */
$pg_twitter = '';
$pg_domain = '';

$pg_sitekit = INCLUDE_PATH . 'img/sitekit/';

/**
 * ============================================= *
 * Definido as configuraçõs de URL amigável      *
 * ============================================= *
 */
$getUrl = strip_tags(trim(filter_input(INPUT_GET, 'url', FILTER_DEFAULT)));
$setUrl = (empty($getUrl) ? 'construcao' : $getUrl);
$Url = explode('/', $setUrl);

switch ($Url[0]):
    case 'home':
        $pg_title = $pg_name;
        $pg_desc = 'Quantum Medical';
        $pg_image = $pg_sitekit . 'logo-300x100.PNG';
        $pg_url = HOME;
        break;

    case 'quem-somos':
        $pg_title = 'Quem Somos | ' . SITENAME;
        $pg_desc = 'Quantum Medical';
        $pg_image = $pg_sitekit . 'logo-300x100.PNG';
        $pg_url = HOME . DIRECTORY_SEPARATOR . 'sobre';
        break;

    case 'contato':
        $pg_title = 'Contato | ' . SITENAME;
        $pg_desc = 'Faça um contato com a Quantum Medical';
        $pg_image = $pg_sitekit . 'logo-300x100.PNG';
        $pg_url = HOME . DIRECTORY_SEPARATOR . 'contato';
        break;
    
    case 'produtos':
        $pg_title = 'Conheça nossos produtos | ' . SITENAME;
        $pg_desc = 'Conheça nossos produtos!';
        $pg_image = $pg_sitekit . 'logo-300x100.PNG';
        $pg_url = HOME . DIRECTORY_SEPARATOR . 'produtos';
        break;

    case 'construcao':
        $pg_title = 'Site em construção | ' . SITENAME;
        $pg_desc = 'Desculpe-nos pelo transtorno, mas estamos em construção. Por favor volte mais tarde!';
        $pg_image = $pg_sitekit . 'logo-300x100.PNG';
        $pg_url = HOME . DIRECTORY_SEPARATOR . 'construcao';
        break;

    default:
        $pg_title = 'Desculpe, não encontrado o conteúdo relacionado.';
        $pg_desc = 'Você está vendo agora a página 404 pois não encontramos conteúdo relacionado à <b>' . $setUrl . '</b>, mas não saia ainda. Temos algumas dicas para te ajudar com sua pesquisa!';
        $pg_image = $pg_sitekit . 'logo-300x100.PNG';
        $pg_url = HOME . DIRECTORY_SEPARATOR . '404';
        break;
endswitch;

// AUTO LOAD DE CLASSES  ############################
function __autoload($Class) {
    $cDir = ['Conn', 'Helpers', 'Models'];
    $iDir = null;

    foreach ($cDir as $dirName):/* caso haja problema trocar o  . DIRECTORY_SEPARATOR .  por // ou \\ */
        if (!$iDir && file_exists(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php') && !is_dir($dirName)):
            include_once (__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php');
            $iDir = true;
        endif;
    endforeach;

    if (!$iDir):
        trigger_error("Não foi possível incluir {$Class}.class.php", E_USER_ERROR);
        die;
    endif;
}

// TRATAMENTO DE ERROS   ############################
// CSS constantes :: Mensagens de Erro ##############
define('WS_ACCEPT', 'accept');
define('WS_INFOR', 'infor');
define('WS_ALERT', 'alert');
define('WS_ERROR', 'error');

//WSErro :: Exibe erros lançados :: Front
function WSErro($ErrMsg, $ErrNo, $ErrDie = null) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));
    echo "<p class=\"trigger {$CssClass}\">{$ErrMsg}<span class=\"ajax_close\"></span></p>";

    if ($ErrDie):
        die;
    endif;
}

//PHPErro :: personaliza o gatilho do PHP
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));
    echo "<p class=\"trigger {$CssClass}\">";
    echo "<b>Erro na linha: {$ErrLine} ::</b> {$ErrMsg}<br>";
    echo "<small>{$ErrFile}</small>";
    echo "<span class=\"ajax_close\"></span></p>";

    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

set_error_handler('PHPErro');

