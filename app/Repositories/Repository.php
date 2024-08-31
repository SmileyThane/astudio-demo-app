<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Repository
{
    private Model $model;

    private const int PER_PAGE = 10;

    public function __construct(string $model)
    {
        $this->model = new $model;
    }

    final public function all(array $data): LengthAwarePaginator
    {
        return $this->appendFilterOptions($data)->paginate($this->getPerPage($data));
    }

    final public function create(array $data): Model
    {
        return $this->model->firstOrCreate($data);
    }

    final public function update(int $id, array $data): bool
    {
        return $this->findById($id)->update($data);
    }

    final public function findById(int $id, array $with = []): Model
    {
        return $this->model->with($with)->findOrFail($id);
    }

    final public function delete(int $id): bool
    {
        return $this->findById($id)->delete();
    }

    private function getPerPage(array $data): int
    {
        if (array_key_exists('per_page', $data)) {
            return (int)$data['per_page'];
        }
        return self::PER_PAGE;
    }

    private function appendFilterOptions(array $data): Builder|Model
    {
        $attributes = $this->model->getFillable();
        $intersect = array_intersect($attributes, array_keys($data));

        $query = $this->model;
        foreach ($intersect as $attribute) {
            $query = $query->whereLike($attribute, '%' . $data[$attribute] . '%', false);
        }

        return $query;
    }
}
