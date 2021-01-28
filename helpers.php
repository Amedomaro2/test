<?php

use App\Utils\View;

function view(string $template, array $data = []): string
{
    //тут мы создаем путь к папке /view там где наши хранятся шаблоны
    $view = new View(__DIR__ . '/view');
    // и возрашаем наш переменную которы берет функцию в папке утил view
    return $view->show($template, $data);
}

function error($name)
{
    if (isset($_SESSION['errors'][$name])) {
        return $_SESSION['errors'][$name];
    }
    return null;
}