<?php

namespace App\Contracts;

use App\Models\News;
use Illuminate\Pagination\AbstractPaginator;

interface NewsRepositoryInterface extends BaseRepositoryInterface {

	public function create(array $attributes): News;

	public function update(array $attributes): bool;

	public function find($id): ?News;

	public function getPaginatedTese(int $count, int $page, array $columns, string $search = null): AbstractPaginator;

	public function deleteIfNotExists(array $symbols): void;

	public function updateOrCreate(string $column, string $value, array $attributes): bool;
}