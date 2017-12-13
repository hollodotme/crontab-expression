<?php declare(strict_types=1);
/**
 * @author h.woltersdorf
 */

namespace hollodotme\CrontabExpression\Tests\Unit\Sections;

use hollodotme\CrontabExpression\Sections\DayOfMonthSection;
use PHPUnit\Framework\TestCase;

/**
 * Class DayOfMonthSectionTest
 * @package hollodotme\CrontabExpression\Tests\Unit\Sections
 */
final class DayOfMonthSectionTest extends TestCase
{
	/**
	 * @param string $sectionValue
	 * @param string $dateString
	 *
	 * @dataProvider dueHoursProvider
	 */
	public function testIsSatisfiedBy( string $sectionValue, string $dateString )
	{
		$dayOfMonthSection = new DayOfMonthSection( $sectionValue );
		$dateTime          = new \DateTimeImmutable( $dateString );

		$this->assertTrue( $dayOfMonthSection->isSatisfiedBy( $dateTime ) );
	}

	public function dueHoursProvider() : array
	{
		return [
			[
				'sectionValue' => '*',
				'dateString'   => '2017-12-12 13:53:21',
			],
			# Steps
			[
				'sectionValue' => '*/2',
				'dateString'   => '2017-12-03 02:02:21',
			],
			[
				'sectionValue' => '*/2',
				'dateString'   => '2017-12-7 10:54:21',
			],
			[
				'sectionValue' => '1',
				'dateString'   => '2017-12-01 01:01:21',
			],
			[
				'sectionValue' => '02',
				'dateString'   => '2017-12-02 02:02:21',
			],
			[
				'sectionValue' => '23',
				'dateString'   => '2017-12-23 23:12:21',
			],
			# Lists
			[
				'sectionValue' => '1,3,31',
				'dateString'   => '2017-12-01 00:12:21',
			],
			[
				'sectionValue' => '1,3,31',
				'dateString'   => '2017-12-03 03:22:21',
			],
			[
				'sectionValue' => '01,03,31',
				'dateString'   => '2017-12-31 22:44:21',
			],
			# Ranges
			[
				'sectionValue' => '12-22',
				'dateString'   => '2017-12-12 12:18:21',
			],
			[
				'sectionValue' => '12-22',
				'dateString'   => '2017-12-15 13:12:21',
			],
			[
				'sectionValue' => '12-22',
				'dateString'   => '2017-12-22 22:22:21',
			],
			# List with ranges
			[
				'sectionValue' => '1-6,12-22',
				'dateString'   => '2017-12-1 02:18:21',
			],
			[
				'sectionValue' => '1-6,12-22',
				'dateString'   => '2017-12-5 13:33:21',
			],
			[
				'sectionValue' => '1-6,12-22',
				'dateString'   => '2017-12-12 19:44:21',
			],
			[
				'sectionValue' => '1-6,12-22',
				'dateString'   => '2017-12-22 19:44:21',
			],
			# Ranges with steps
			[
				'sectionValue' => '12-22/2',
				'dateString'   => '2017-12-12 14:14:21',
			],
			[
				'sectionValue' => '12-22/2',
				'dateString'   => '2017-12-14 16:16:21',
			],
			[
				'sectionValue' => '12-22/2',
				'dateString'   => '2017-12-20 18:14:21',
			],
			[
				'sectionValue' => '12-22/2',
				'dateString'   => '2017-12-22 22:16:21',
			],
			# List with ranges and steps
			[
				'sectionValue' => '1-8/3,12-22/2',
				'dateString'   => '2017-12-04 3:36:21',
			],
			[
				'sectionValue' => '1-8/3,12-22/2',
				'dateString'   => '2017-12-16 14:36:21',
			],
			# Last day of month
			[
				'sectionValue' => 'L',
				'dateString'   => '2017-12-31 14:36:21',
			],
			# Nearest weekday
			[
				'sectionValue' => '8W',
				# This is a Friday
				'dateString'   => '2017-12-08 14:36:21',
			],
			[
				'sectionValue' => '9W',
				# 2017-12-09 is a Saturday and should be satisfied with the previous Friday
				# This is a Friday
				'dateString'   => '2017-12-08 14:36:21',
			],
			[
				'sectionValue' => '10W',
				# 2017-12-10 is a Sunday and should be satisfied with the next Monday
				# This is a Monday
				'dateString'   => '2017-12-11 14:36:21',
			],
			[
				'sectionValue' => '1W',
				# 2017-07-01 is a Saturday and the first of month, should be satisfied with the next Monday
				# This is a Monday
				'dateString'   => '2017-07-03 14:36:21',
			],
			[
				'sectionValue' => '30W',
				# 2017-04-30 is a Sunday and the last of month, should be satisfied with the previous Friday
				# This is a Monday
				'dateString'   => '2017-04-28 14:36:21',
			],
		];
	}
}
