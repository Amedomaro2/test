<?php

namespace App\Utils;

use App\Exception\Exception404;
use App\Exception\ValidationException;

class Router
{

    // тут в процесе мы должны обрабатывать ошибки (Exception)
    public function process()
    {
        try {
            // Формирования сылки
            $action = $this->getAction();
            // мы запихиваем в контролер масив сылки контролер (путь к классу)
            $controller = $action[0];
            // и метод (функция которую надо вызвать)
            $method = $action[1];
            // создаем клас по этому пути
            $object = new $controller;
            //и обрашаемся к функции этого класса
            $object->$method();
            unset($_SESSION['errors']);
        } catch (Exception404 $exception) {
            return view('404');
        } catch (ValidationException $exception) {
            $this->handleValidationException($exception);
        } catch (\Exception $exception) {
            //
        }
    }


    private function getAction() : array
    {
        // смотреть укро 9  там это все описано, а в 10 описано эксепшены
        // Получаем PATH от ссылки
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        // Разбиваем ссылку на массив по элементам
        $url = explode('/', $url);

        // Формируем полный неймспейс класса
        if (empty($url[1])) {
            $controller = '\App\Controller\HomeController';
        } else {
            $controller = '\App\Controller\\' . ucfirst($url[1]) . 'Controller';
            if (!class_exists($controller)) {
                throw new Exception404('Error 404');
            }
        }

        if (empty($url[2])) {
            $method = 'index';
        } else {
            $method = $url[2];
        }

        // если нет такоего метода(функции) в контролере (классе) то выводим ошибку что (сылка неправельно сгенерилась
        // или такой ерунды нет)
        if (!method_exists($controller, $method)) {
            throw new Exception404('Error 404');
        }
        // если все это прошло то отдаем масив обратно по запросу
        return [$controller, $method];
    }

    private function handleValidationException(ValidationException $exception)
    {
        $referer = parse_url($_SERVER['HTTP_REFERER']);
        $url = 'http://' . $referer['host'] . $referer['path'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_SESSION['errors'] = $exception->getErrors();
            $_SESSION['data'] = $_POST;
        } else {

        }

        header('Location: ' . $url);
        exit;
    }
}