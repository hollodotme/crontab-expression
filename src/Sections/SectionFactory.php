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
	public function getSection( int $sectionType, string $sectionValue ) : ChecksSectionDueDate
	{
		$value = strtoupper( $sectionValue );

		switch ( $sectionType )
		{
			case SectionType::SECTION_MINUTE:
				return new MinuteSection( $value );

			case SectionType::SECTION_HOUR:
				return new HourSection( $value );

			case SectionType::SECTION_DAY_OF_MONTH:
				return new DayOfMonthSection( $value );

			case SectionType::SECTION_MONTH:
				return new MonthSection( $value );

			case SectionType::SECTION_DAY_OF_WEEK:
				return new DayOfWeekSection( $value );

			default:
				throw new LogicException( 'Invalid crontab expression section: ' . $sectionType );
		}
	}
}
