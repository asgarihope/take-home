<?php

namespace App\Http\Requests;

use App\Enums\NewsResourceEnum;
use Illuminate\Foundation\Http\FormRequest;

class NewsFilterRequest extends FormRequest {

	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array {
		return [

			NewsResourceEnum::TITLE                   => ['sometimes', 'nullable', 'string', 'max:255'],
			NewsResourceEnum::BODY                    => ['sometimes', 'nullable', 'string', 'max:255'],
			NewsResourceEnum::AUTHOR                  => ['sometimes', 'nullable', 'string', 'size:255'],
			NewsResourceEnum::CATEGORY                => ['sometimes', 'nullable', 'size:255'],
			NewsResourceEnum::PUBLISHED_AT            => ['sometimes', 'nullable', 'array', 'size:2'],
			NewsResourceEnum::PUBLISHED_AT . '.year'  => ['nullable', 'numeric'],
			NewsResourceEnum::PUBLISHED_AT . '.month' => ['nullable', 'numeric'],
			NewsResourceEnum::PUBLISHED_AT . '.day'   => ['nullable', 'numeric'],

			'sort' => ['sometimes', 'nullable', 'in:' . implode(',', array_keys(NewsResourceEnum::sortableColumns))],
		];
	}

}
