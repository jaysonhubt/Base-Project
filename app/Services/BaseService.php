<?php


namespace App\Services;


class BaseService
{
    protected $repository;

    public function all(array $columns = ['*'])
    {
        return $this->repository->all($columns);
    }

    public function count(array $where = [], $columns = '*')
    {
        return $this->repository->count($where, $columns);
    }

    public function first($columns = ['*'])
    {
        return $this->repository->first($columns);
    }

    public function firstOrNew(array $attributes = [])
    {
        return $this->repository->firstOrNew($attributes);
    }

    public function firstOrCreate(array $attributes = [])
    {
        return $this->repository->firstOrCreate($attributes);
    }

    public function limit($limit)
    {
        return $this->repository->limit($limit);
    }

    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {
        return $this->repository->paginate($limit, $columns, $method);
    }

    public function find($id, $columns = ['*'])
    {
        return $this->repository->find($id, $columns);
    }

    public function findByField($field, $value = null, $columns = ['*'])
    {
        return $this->repository->findByField($field, $value, $columns);
    }

    public function findWhere(array $where, $columns = ['*'])
    {
        return $this->repository->findWhere($where, $columns);
    }

    public function findWhereIn($field, array $values, $columns = ['*'])
    {
        return $this->repository->findWhereIn($field, $values, $columns);
    }

    public function findWhereNotIn($field, array $values, $columns = ['*'])
    {
        return $this->repository->findWhereNotIn($field, $values, $columns);
    }

    public function create(array $attributes)
    {
        return $this->repository->create($attributes);
    }

    public function update(array $attributes, $id)
    {
        return $this->repository->update($attributes, $id);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function deleteWhere(array $where)
    {
        return $this->repository->deleteWhere($where);
    }

    public function with($relations)
    {
        return $this->repository->with($relations);
    }

    public function withCount($relations)
    {
        return $this->repository->withCount($relations);
    }

    public function orderBy($column, $direction = 'asc')
    {
        return $this->repository->orderBy($column, $direction);
    }

    public function updateOrCreate(array $attributes, array $values = [])
    {
        return $this->repository->updateOrCreate($attributes, $values);
    }
}
