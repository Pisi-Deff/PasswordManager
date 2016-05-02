<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

ob_start();

define('PASSWORD_MANAGER', true);
define('VERSION', '1.0');

spl_autoload_register(function ($class) {
    $filenames = array(
        'php/classes/' . $class . '.class.php',
        'php/pages/' . $class . '.class.php'
    );
    foreach ($filenames as $filename){
        if (file_exists($filename)) {
            include $filename;
            break;
        }
    }
});

$pageFactory = new PageFactory('ChangePasswordPage');

$page = $pageFactory->getPage($_GET, $_POST);
echo $page->render();