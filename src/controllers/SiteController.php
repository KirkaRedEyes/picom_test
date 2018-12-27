<?php

require 'Controller.php';
require 'models/Site.php';

class SiteController extends Controller
{
    /** Получение данных из базы данных */
    public function loadFromDataBaseAction()
    {
        $modelSite = new Site();

        echo $this->render('content', [
            'action' => 'db',
            'users' => $modelSite->loadFromDB()
        ]);
    }

    /** Получение данных из файла user */
    public function loadFromFileAction()
    {
        $modelSite = new Site();

        echo $this->render('content', [
            'action' => 'file',
            'users' => $modelSite->loadFromFile()
        ]);
    }

    /** Заполнение таблицы users */
    public function generateDataBaseAction()
    {
        $modelSite = new Site();

        if ($modelSite->generateDB())
            $this->loadFromDataBaseAction();
    }

    /** Удаление user по id из базы данных */
    public function removeFromDataBaseAction()
    {
        $modelSite = new Site();

        if ($modelSite->removeFromDB())
            $this->loadFromDataBaseAction();
    }

    /** Заполнение файла user */
    public function generateFileAction()
    {
        $modelSite = new Site();

        if ($modelSite->generateFile())
            $this->loadFromFileAction();
    }

    /** Удаление user по id из файла */
    public function removeFromFileAction()
    {
        $modelSite = new Site();

        if ($modelSite->removeFromFile())
            $this->loadFromFileAction();
    }
}