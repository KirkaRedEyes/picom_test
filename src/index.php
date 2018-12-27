<?php

//error_reporting(E_ERROR);

require 'vendor/autoload.php';

/** Временная зона */
date_default_timezone_set('Europe/Saratov');

/** Нормализация имени контроллера */
function normalizeControllerName($name)
{
    return ucfirst(strtolower($name)) . 'Controller';
}

/** Нормализация действия контроллера */
function normalizeActionName($name)
{
    $words = explode('-', $name);
    $len = count($words);
    $words[0] = strtolower($words[0]);
    if ($len > 1) {
        for ($i = 1; $i < $len; ++$i) {
            $words[$i] = ucfirst(strtolower($words[$i]));
        }
    }
    return implode('', $words) . 'Action';
}

/** Открытие нужной страницы */
if (!empty($_GET)) {
    $controllerName = normalizeControllerName($_GET['controller']);
    $actionName = normalizeActionName($_GET['action']);

    if (file_exists("controllers/{$controllerName}.php")) {
        require "controllers/{$controllerName}.php";
        $controller = new $controllerName();
        if (method_exists($controller, $actionName)) {
            $controller->$actionName();
        } else {
            throw new Exception('Такого action не существует.');
        }
    } else {
        throw new Exception('Такой controller не существует');
    }
} else {
    require "controllers/SiteController.php";
    $controller = new SiteController();
    $controller->loadFromFileAction();
}

