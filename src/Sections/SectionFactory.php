<?php declare(strict_types=1);
/**
 * @author h.woltersdorf
 */

namespace hollodotme\CrontabExpression\Sections;

use hollodotme\CrontabExpression\Exceptions\LogicException;
use hollodotme\CrontabExpression\Interfaces\ChecksSectionDueDate;

/**
 * Class SectionFactory
 * @package hollodotme\CrontabExpression\Sections
 */
final class SectionFactory
{
	private const SECTION_MINUTE       = 0;

	private const SECTION_HOUR         = 1;

	private const SECTION_DAY_OF_MONTH = 2;

	private const SECTION_MONTH        = 3;

	private const SECTION_DAY_OF_WEEK  = 4;

	public function getSection( int $sectionType, string $sectionValue ) : ChecksSectionDueDate
	{
		$value = strtoupper( $sectionValue );
		
		switch ( $sectionType )
		{
			case self::SECTION_MINUTE:
				return new MinuteSection( $value );

			case self::SECTION_HOUR:
				return new HourSection( $value );

			case self::SECTION_DAY_OF_MONTH:
				return new DayOfMonthSection( $value );

			case self::SECTION_MONTH:
				return new MonthSection( $value );

			case self::SECTION_DAY_OF_WEEK:
				return new DayOfWeekSection( $value );

			default:
				throw new LogicException( 'Invalid crontab expression section: ' . $sectionType );
		}
	}
}
