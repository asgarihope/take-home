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

}
