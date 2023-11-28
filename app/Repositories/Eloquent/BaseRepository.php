<?php

namespace App\Repositories\Eloquent;

use App\Enums\ResourceSearchOperatorsEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\AbstractPaginator;

class BaseRepository {

	protected $model;
	protected $builder;

	public function __construct(Model $model) {
		$this->model   = $model;
		$this->builder = $this->model->newQuery();
	}

	protected function create(array $attributes): Model {
		$this->model = $this->model->create($attributes);

		return $this->model->refresh();
	}

	protected function update(array $attributes): bool {
		return $this->model->whereId($attributes['id'])->update($attributes);
	}

	protected function delete(int $modelID): bool {
		return $this->model->whereId($modelID)->delete();
	}

	protected function findByID(int $modelID): Model {
		return $this->model->whereId($modelID)->firstOrFail();
	}

	protected function getFilteredResources(
		array $filters,
		array $columns = ['*'],
		array $relations = [],
		array $sorts = ['column' => 'id', 'direction' => 'desc'],
		int   $page = 1,
		int   $perPage = 12
	): AbstractPaginator {
		$builder = $this->builder;
		foreach ($filters as $filter) {

			switch ($filter['type']) {
				case ResourceSearchOperatorsEnum::EQUAL_TO :
					$builder = $builder->where($filter['column'], '=', "{$filter['value']}");
					break;
				case ResourceSearchOperatorsEnum::LIKE :
					$builder = $builder->where($filter['column'], 'like', "%{$filter['value']}%");
					break;
				case ResourceSearchOperatorsEnum::BETWEEN:
					$builder = $builder->whereBetween($filter['column'], $filter['value']);
					break;
				case ResourceSearchOperatorsEnum::GREATER_THAN:
					$builder = $builder->where($filter['column'], '>', $filter['value']);
					break;
				case ResourceSearchOperatorsEnum::LESS_THAN:
					$builder = $builder->where($filter['column'], '<', $filter['value']);
					break;
				case ResourceSearchOperatorsEnum::NOT_EQUAL_TO:
					$builder = $builder->whereNotNull($filter['column']);
					break;
				case ResourceSearchOperatorsEnum::IN_LIST:
					$builder = $builder->whereIn($filter['column'], explode(',', $filter['value']));
					break;
				case ResourceSearchOperatorsEnum::IN_RELATION_LIST:
					$builder = $builder->whereHas($filter['relation'], function ($q) use ($filter) {
						return $q->whereIn($filter['column'], $filter['value']);
					});
					break;
				default :
					$builder = $builder->where($filter['column'], $filter['value']);
			}
		}

		$builder = $builder->with($relations);

		if (isset($sorts['column']) && isset($sorts['direction'])) {
			$builder = $builder->orderBy($sorts['column'], $sorts['direction']);
		} else {
			foreach ($sorts as $sort) {
				$builder = $builder->orderBy($sort['column'], $sort['direction']);
			}
		}

		return $builder->paginate($perPage, $columns, 'page', $page)->onEachSide(1);
	}
}
