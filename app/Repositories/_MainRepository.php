<?php

namespace App\Repositories;

use App\Contracts\BaseRepositoryInterface;
use App\Enums\ResourceSearchOperatorsEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\AbstractPaginator;

class _MainRepository implements BaseRepositoryInterface {

	protected $model;
	protected $builder;

	public function __construct(Model $model) {
		parent::__construct($model);
		$this->builder = $this->model->newQuery();
	}

	public function create(array $attributes): Model {
		$this->model = $this->model->create($attributes);

		return $this->model->refresh();
	}

	public function update(array $attributes): bool {
		return $this->model->whereId($attributes['id'])->update($attributes);
	}

	public function getPaginatedResources(
		int    $count,
		int    $page,
		array  $columns,
		string $search = null,
		array  $relations = []
	): AbstractPaginator {
		$builder = $this->model->newQuery();
		if (!is_null($search)) {
			$builder = $builder->where('name', 'like', "%$search%");
		}

		return $builder->with($relations)->orderByDesc('id')->paginate($count, $columns, 'page', $page);
	}

	public function getFilteredResources(
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
