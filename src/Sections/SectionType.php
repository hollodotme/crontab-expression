<?php declare(strict_types=1);
/**
 * @author h.woltersdorf
 */

namespace hollodotme\CrontabExpression\Sections;

/**
 * Class SectionType
 * @package hollodotme\CrontabExpression\Sections
 */
abstract class SectionType
{
	public const SECTION_MINUTE       = 0;

	public const SECTION_HOUR         = 1;

	public const SECTION_DAY_OF_MONTH = 2;

	public const SECTION_MONTH        = 3;

	public const SECTION_DAY_OF_WEEK  = 4;
}
