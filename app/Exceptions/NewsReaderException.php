<?php

namespace App\Exceptions;

use Exception;

class NewsReaderException extends Exception {

	public function render() {
		return response()->json([
			'message' => $this->message,
		])->setStatusCode($this->getCode()?:400);
	}
}
