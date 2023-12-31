<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface RequestUtilsInterface {

	public function setRequest(Request $request): self;

	public function setParameterValue(string $parameter, $value): void;

	public function removeParameter(string $parameter): void;

	public function convertToFilterFormat(string $parameter, $input): bool;

	public function makeResourceSearchFromRequest(array $filterableColumns): void;

}
