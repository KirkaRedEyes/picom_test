<?php

class Controller {

    /** @var string название файла по умолчанию*/
    public $layout = 'main';

    /**
     * Получение имени контроллера
     *
     * @return string.
     */
    protected function getControllerId()
	{
		$className = str_split(get_called_class());
		$name_controller = array_splice($className, 0, -10);
		return strtolower(implode('', $name_controller));
	}

    /**
     * Генерирование страницы
     *
     * @param string $viewName имя представления
     * @param array $params массив с переменными, которые будут доступны на странице
     */
	protected function render($viewName, $params = array())	{
		extract($params);
		ob_start();
		require 'views/' . $this->getControllerId() . '/' . $viewName . '.php';
        $content = ob_get_clean();
        require "views/layouts/{$this->layout}.php";
    }
}