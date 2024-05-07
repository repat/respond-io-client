<?php

namespace Repat\RespondIoClient;

use Repat\RespondIoClient\Exceptions\RespondIoException;

class ContactFilter
{
	/**
	 * General search string.  If set will be looked for in all available fields
	 */
	private $search;

	private $filterType;

	/**
	 * Filter Object used to contain all filters
	 */
	private $filter;

	/**
	 * All operators available, populated by constructor to contain all OPERATOR_ constants below
	 */
	private $operators = [];

	public const TIMEZONE = 'UK/London';

	/**
	 * All available operator constants
	 */
	public const OPERATOR_ISEQUALTO = 'isEqualTo';
	public const OPERATOR_ISNOTEQUALTO = 'isNotEqualTo';
	public const OPERATOR_ISTIMESTAMPAFTER = 'isTimestampAfter';
	public const OPERATOR_ISTIMESTAMPBEFORE = 'isTimestampBefore';
	public const OPERATOR_ISTIMESTAMPBETWEEN = 'isTimestampBetween';
	public const OPERATOR_EXISTS = 'exists';
	public const OPERATOR_DOESNOTEXIST = 'doesNotExist';
	public const OPERATOR_ISGREATERTHAN = 'isGreaterThan';
	public const OPERATOR_ISLESSTHAN = 'isLessThan';
	public const OPERATOR_ISBETWEEN = 'isBetween';
	public const OPERATOR_HASANYOF = 'hasAnyOf';
	public const OPERATOR_HASALLOF = 'hasAllOf';
	public const OPERATOR_HASNONEOF = 'hasNoneOf';

	const FIELDS = [
		"firstName",
		"lastName",
		"phone",
		"email",
		"status",
		"tags"
	];

	public function __construct(string $search = '', string $filterType = 'and')
	{
		$this->search = $search;
		$this->filterType = '$'.$filterType;

		$this->filter = new \stdClass();
		$this->filter->{$this->filterType} = [];

		// populate operators property with all available FILTER_ constants
		$this->operators = array_filter((new \ReflectionClass($this))->getConstants(), function($key){
			return preg_match('/^OPERATOR_/', $key);
		}, ARRAY_FILTER_USE_KEY);
	}

	public function addFilter(string $field, string $operator, string | array $value): self
	{
		if(!in_array($field, self::FIELDS)) {
			throw new RespondIoException("$field field not allowed in filter");
		}

		if(!in_array($operator, $this->operators)) {
			throw new RespondIoException("$operator operator not allowed in filter");
		}

		$filterItem = new \stdClass();
		$filterItem->category = 'contactField';
		$filterItem->field = $field;
		$filterItem->operator = $operator;
		$filterItem->value = $value;

		array_push($this->filter->{$this->filterType}, $filterItem);

		return $this;
	}

	public function toJson()
	{
		$filter = new \stdClass();
		$filter->search = $this->search;
		$filter->timezone = self::TIMEZONE;
		$filter->filter = $this->filter;

		return json_encode($filter);
	}
}
