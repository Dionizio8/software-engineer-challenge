<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create($attributes)
    {
        $model = $this->model->newInstance($attributes);

        $model->save();

        return $model;
    }

    public function bulk($attributes)
    {
        $model = $this->model->insert($attributes);

        return $model;
    }
}
