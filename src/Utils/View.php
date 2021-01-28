<?php
// этот клас отвечает за рендоринг шаблонов в папке View
namespace App\Utils;

class View
{
    private string $templateDir;

    /**
     * View constructor.
     * @param $templateDir
     */
    public function __construct(string $templateDir)
    {
        $this->templateDir = $templateDir;
    }

    // этот метод непосредствено показывает
    public function show(string $template, array $data = []) : string
    {
        // превращаем из массива в набор переменных
        extract($data, EXTR_OVERWRITE);
        // меняем все точки на слеши то что получили в template
        $templatePath = str_replace('.', '/', $template);
        // формируем полный путь к файлу включая назавние файла
        return require $this->templateDir . '/' . $templatePath . '.template.php';
    }
}