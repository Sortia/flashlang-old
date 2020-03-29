<?php

namespace App\Repositories;

abstract class Repository
{
    /**
     * Получить пустой экземпляр модели
     */
    public function getModel()
    {
        $className      = $this->getClassName();
        $modelClassName = $this->getModelClassName($className);
        $path           = '\\App\\Models\\' . $modelClassName;

        return new $path();
    }

    /**
     * Получение всех записей из базы
     */
    public function all()
    {
        return $this->getModel()->all();
    }

    /**
     * Получение названия текущего класса
     */
    protected function getClassName(): string
    {
        return substr(strrchr(get_class($this), "\\"), 1);
    }

    /**
     * Получение названия модели исходя из соглашения что название класса репозитория
     * это название класса модели + Repository
     */
    protected function getModelClassName($className): string
    {
        return str_replace('Repository', '', $className);
    }
}
