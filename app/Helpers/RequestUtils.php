<?php

namespace App\Helpers;

use App\Contracts\RequestUtilsInterface;
use App\Enums\ResourceSearchOperatorsEnum;
use Illuminate\Http\Request;

class RequestUtils implements RequestUtilsInterface {

	protected Request $formRequest;

	public function setRequest(Request $request): self {
		$this->formRequest = $request;

		return $this;
	}

	public function setParameterValue(string $parameter, $value): void {
		$this->formRequest->request->set($parameter, $value);
		$this->formRequest->merge([$parameter => $value]);
	}

	public function removeParameter(string $parameter): void {
		unset($this->formRequest[$parameter]);
		$this->formRequest->replace(array_merge($this->formRequest->request->all(),$this->formRequest->all()));
	}

//	public function convertBooleanInputs(array $parameters, $fillWithFalse = false): void {
//		foreach ($parameters as $parameter) {
//			if ($this->formRequest->has($parameter) && $this->formRequest->filled($parameter)) {
//				$value = filter_var($this->formRequest->input($parameter), FILTER_VALIDATE_BOOLEAN);
//				$this->setParameterValue($parameter, $value);
//				continue;
//			}
//
//			if ($fillWithFalse) {
//				$this->setParameterValue($parameter, false);
//				continue;
//			}
//
//			$this->removeParameter($parameter);
//		}
//	}



	public function makeResourceSearchFromRequest(array $filterableColumns): void {
		foreach ($filterableColumns as $parameter => $input) {
			if (!$this->formRequest->has($parameter)) {
				continue;
			}

			switch ($input['type']) {
//				case ResourceSearchOperatorsEnum::BETWEEN:
//					$this->convertToRangeFilterFormat($parameter, $input);
//					break;
				default:
					$this->convertToFilterFormat($parameter, $input);
					break;
			}
		}
	}

	public function convertToFilterFormat(string $parameter, $input): bool {
		if (!$this->formRequest->filled($parameter)) {
			$this->removeParameter($parameter);

			return false;
		}
		$this->setParameterValue($parameter, array_merge($input, ['value' => $this->formRequest->get($parameter)]));

		return true;
	}

//	public function convertToRangeFilterFormat(string $parameter, $input): bool {
//		if (is_null($this->formRequest->{"{$parameter}.min"}) && is_null($this->formRequest->{"{$parameter}.max"})) {
//			$this->removeParameter($parameter);
//
//			return false;
//		}
//
//		$this->setParameterValue($parameter,
//			array_merge($input, [
//				'value' => [
//					(int)($this->formRequest->{"{$parameter}.min"} ?? 0),
//					(int)($this->formRequest->{"{$parameter}.max"} ?? PHP_INT_MAX),
//				],
//			]));
//
//		return true;
//	}
//
//	public function maskSensitiveInputs(array $requestBag, string $pattern): array {
//		$keys = [
//			'pwd',
//			'password',
//			'repassword',
//			'password_confirmation'
//		];
//
//		array_walk($requestBag, function (&$item, $key) use ($keys, $pattern) {
//			$key = strtolower($key);
//			$item = in_array($key, $keys) ? $pattern : $item;
//		});
//
//		return $requestBag;
//	}
//
//	public function setResourceDescription(string $key, int $resourceId, string $resourceType): void {
//		$resourceDescription = $this->formRequest->{$key};
//
//		data_set($resourceDescription, '*.resource_type', $resourceType);
//		data_set($resourceDescription, '*.resource_id', $resourceId);
//
//		$this->setParameterValue($key, $resourceDescription);
//	}
//
//	public function convertToListFormat(array $parameters) {
//		// TODO: Implement convertToListFormat() method.
//	}
}
