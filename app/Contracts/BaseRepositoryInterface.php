<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
	public function create(array $attributes): Model;

	public function update(array $attributes): bool;

	public function getPaginatedResources(
		int    $count,
		int    $page,
		array  $columns,
		string $search = null,
		array  $relations = []
	): AbstractPaginator;

	public function getFilteredResources(
		array $filters,
		array $columns = ['*'],
		array $relations = [],
		array $sorts = ['column' => 'id', 'direction' => 'desc'],
		int   $page = 1,
		int   $perPage = 12
	): AbstractPaginator;

}
