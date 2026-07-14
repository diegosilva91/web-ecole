<?php

namespace Lifecole\Shared\Infrastructure\Persistence\Eloquent;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;

abstract class EloquentRepository
{
    protected mixed $model;

    public function __construct()
    {
        $this->makeModel();
    }

    public function getByColumn(string $columnName, string $columnValue, string $operator = '='): object
    {
        if (!is_array($columnValue) && !$columnValue instanceof Arrayable) {
            $this->model = $this->model->where($columnName, $operator, $columnValue);
            return $this;
        }
        return $this;
    }
    public function retrieveFirstFromQuery()
    {
        return $this->model->first();
    }
    public function makeModel()
    {
        $this->model = App::make($this->model());

        if ($this->model instanceof Model) {
//            throw (new Exception BadModelException())->setModel(); //todo implement new Exception with setModel Function
        }

        return $this->model;
    }

    abstract protected function model(): string;
}
