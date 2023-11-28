<?php

namespace App\Enums;

final class ResourceSearchOperatorsEnum {

	const EQUAL_TO = 'equalTo';
	const LIKE = 'like';
	const GREATER_THAN = 'greaterThan';
	const LESS_THAN = 'lessThan';
	const NOT_EQUAL_TO = 'notEqualTo';
	const BETWEEN = 'between';
	const BETWEEN_DATE = 'betweenDate';
	const BOOLEAN = 'boolean';
	const IN_LIST = 'inList';
	const IN_RELATION_LIST = 'inRelationList';
}
