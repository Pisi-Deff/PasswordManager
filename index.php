<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

ob_start();

define('PASSWORD_MANAGER', true);
define('APPID', 'passman');
define('VERSION', '1.0');

require_once './configlink.php';

@date_default_timezone_set(date_default_timezone_get());

spl_autoload_register(function ($class) {
    $filenames = array(
        'php/classes/' . $class . '.class.php',
        'php/controllers/' . $class . '.class.php'
    );
    foreach ($filenames as $filename){
        if (file_exists($filename)) {
            include_once $filename;
            break;
        }
    }
});

Logger::init($cfg);
$pageFactory = new PageFactory('ChangePasswordPage');
$dbActions = new DatabaseActions($cfg);

function error_handler($e) {
    Logger::getInstance()->logUnhandledException($e);
    error_log($e);

    require_once 'php/templates/errorPage.tpl.php';
    echo \tpl\errorPage('An unexpected error occurred. Please contact administration');
}
set_exception_handler("error_handler");

$page = $pageFactory->getPage($_GET, $_POST, $cfg, $dbActions);
echo $page->render();