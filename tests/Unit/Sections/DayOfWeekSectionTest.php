<?php declare(strict_types=1);
/**
 * @author h.woltersdorf
 */

namespace hollodotme\CrontabExpression\Tests\Unit\Sections;

use hollodotme\CrontabExpression\Sections\DayOfWeekSection;
use PHPUnit\Framework\TestCase;

/**
 * Class DayOfWeekSectionTest
 * @package hollodotme\CrontabExpression\Tests\Unit\Sections
 */
final class DayOfWeekSectionTest extends TestCase
{
	/**
	 * @param string $sectionValue
	 * @param string $dateString
	 *
	 * @dataProvider invalidDayOfWeekProvider
	 */
	public function testIsNotSatisfiedBy( string $sectionValue, string $dateString ) : void
	{
		$dayOfWeekSection = new DayOfWeekSection( $sectionValue );
		$dateTime         = new \DateTimeImmutable( $dateString );

		$this->assertFalse( $dayOfWeekSection->isSatisfiedBy( $dateTime ) );
	}

	public function invalidDayOfWeekProvider() : array
	{
		return [
			[
				'sectionValue' => '0',
				'dateString'   => '2017-12-25 00:00:00',
			],
			[
				'sectionValue' => '02',
				'dateString'   => '2017-12-25 00:00:00',
			],
			[
				'sectionValue' => 'mon/2',
				'dateString'   => '2017-12-25 00:02:00',
			],
			# Range
			[
				'sectionValue' => '2-FRI',
				'dateString'   => '2017-12-25 00:30:00',
			],
			# List
			[
				'sectionValue' => 'TUE,THU',
				'dateString'   => '2017-12-29 00:20:00',
			],
			# Invalid value
			[
				'sectionValue' => '8',
				'dateString'   => '2017-12-13 00:00:00',
			],
		];
	}

	/**
	 * @param string $sectionValue
	 * @param string $dateString
	 *
	 * @dataProvider dueHoursProvider
	 */
	public function testIsSatisfiedBy( string $sectionValue, string $dateString )
	{
		$dayOfWeekSection = new DayOfWeekSection( $sectionValue );
		$dateTime         = new \DateTimeImmutable( $dateString );

		$this->assertTrue( $dayOfWeekSection->isSatisfiedBy( $dateTime ) );
	}

	public function dueHoursProvider() : array
	{
		return [
			[
				'sectionValue' => '*',
				'dateString'   => '2017-12-12 13:53:21',
			],
			# Sunday
			[
				'sectionValue' => '0',
				'dateString'   => '2017-12-10 02:02:21',
			],
			[
				'sectionValue' => '7',
				'dateString'   => '2017-12-10 02:02:21',
			],
			[
				'sectionValue' => '07',
				'dateString'   => '2017-12-10 02:02:21',
			],
			[
				'sectionValue' => 'SUN',
				'dateString'   => '2017-12-10 02:02:21',
			],
			[
				'sectionValue' => 'sun',
				'dateString'   => '2017-12-10 02:02:21',
			],
			# Monday
			[
				'sectionValue' => '1',
				'dateString'   => '2017-12-11 02:02:21',
			],
			[
				'sectionValue' => '01',
				'dateString'   => '2017-12-11 02:02:21',
			],
			[
				'sectionValue' => 'MON',
				'dateString'   => '2017-12-11 02:02:21',
			],
			[
				'sectionValue' => 'mon',
				'dateString'   => '2017-12-11 02:02:21',
			],
			# Tuesday
			[
				'sectionValue' => '2',
				'dateString'   => '2017-12-12 02:02:21',
			],
			[
				'sectionValue' => '02',
				'dateString'   => '2017-12-12 02:02:21',
			],
			[
				'sectionValue' => 'TUE',
				'dateString'   => '2017-12-12 02:02:21',
			],
			[
				'sectionValue' => 'tue',
				'dateString'   => '2017-12-12 02:02:21',
			],
			# Wednesday
			[
				'sectionValue' => '3',
				'dateString'   => '2017-12-13 02:02:21',
			],
			[
				'sectionValue' => '03',
				'dateString'   => '2017-12-13 02:02:21',
			],
			[
				'sectionValue' => 'WED',
				'dateString'   => '2017-12-13 02:02:21',
			],
			[
				'sectionValue' => 'wed',
				'dateString'   => '2017-12-13 02:02:21',
			],
			# Thursday
			[
				'sectionValue' => '4',
				'dateString'   => '2017-12-14 02:02:21',
			],
			[
				'sectionValue' => '04',
				'dateString'   => '2017-12-14 02:02:21',
			],
			[
				'sectionValue' => 'THU',
				'dateString'   => '2017-12-14 02:02:21',
			],
			[
				'sectionValue' => 'thu',
				'dateString'   => '2017-12-14 02:02:21',
			],
			# Friday
			[
				'sectionValue' => '5',
				'dateString'   => '2017-12-15 02:02:21',
			],
			[
				'sectionValue' => '05',
				'dateString'   => '2017-12-15 02:02:21',
			],
			[
				'sectionValue' => 'FRI',
				'dateString'   => '2017-12-15 02:02:21',
			],
			[
				'sectionValue' => 'fri',
				'dateString'   => '2017-12-15 02:02:21',
			],
			# Saturday
			[
				'sectionValue' => '6',
				'dateString'   => '2017-12-16 02:02:21',
			],
			[
				'sectionValue' => '06',
				'dateString'   => '2017-12-16 02:02:21',
			],
			[
				'sectionValue' => 'SAT',
				'dateString'   => '2017-12-16 02:02:21',
			],
			[
				'sectionValue' => 'sat',
				'dateString'   => '2017-12-16 02:02:21',
			],
			# Last Sunday in month
			[
				'sectionValue' => '0L',
				'dateString'   => '2017-12-31 02:02:21',
			],
			[
				'sectionValue' => '7L',
				'dateString'   => '2017-12-31 02:02:21',
			],
			[
				'sectionValue' => '07L',
				'dateString'   => '2017-12-31 02:02:21',
			],
			[
				'sectionValue' => 'SUNL',
				'dateString'   => '2017-12-31 02:02:21',
			],
			[
				'sectionValue' => 'sunL',
				'dateString'   => '2017-12-31 02:02:21',
			],
			# Last Monday in month
			[
				'sectionValue' => '1L',
				'dateString'   => '2017-12-25 02:02:21',
			],
			[
				'sectionValue' => '01L',
				'dateString'   => '2017-12-25 02:02:21',
			],
			[
				'sectionValue' => 'MONL',
				'dateString'   => '2017-12-25 02:02:21',
			],
			[
				'sectionValue' => 'monL',
				'dateString'   => '2017-12-25 02:02:21',
			],
			# Last Tuesday in month
			[
				'sectionValue' => '2L',
				'dateString'   => '2017-12-26 02:02:21',
			],
			[
				'sectionValue' => '02L',
				'dateString'   => '2017-12-26 02:02:21',
			],
			[
				'sectionValue' => 'TUEL',
				'dateString'   => '2017-12-26 02:02:21',
			],
			[
				'sectionValue' => 'tueL',
				'dateString'   => '2017-12-26 02:02:21',
			],
			# Last Wednesday in month
			[
				'sectionValue' => '3L',
				'dateString'   => '2017-12-27 02:02:21',
			],
			[
				'sectionValue' => '03L',
				'dateString'   => '2017-12-27 02:02:21',
			],
			[
				'sectionValue' => 'WEDL',
				'dateString'   => '2017-12-27 02:02:21',
			],
			[
				'sectionValue' => 'wedL',
				'dateString'   => '2017-12-27 02:02:21',
			],
			# Last Thursday in month
			[
				'sectionValue' => '4L',
				'dateString'   => '2017-12-28 02:02:21',
			],
			[
				'sectionValue' => '04L',
				'dateString'   => '2017-12-28 02:02:21',
			],
			[
				'sectionValue' => 'THUL',
				'dateString'   => '2017-12-28 02:02:21',
			],
			[
				'sectionValue' => 'thuL',
				'dateString'   => '2017-12-28 02:02:21',
			],
			# Last Friday in month
			[
				'sectionValue' => '5L',
				'dateString'   => '2017-12-29 02:02:21',
			],
			[
				'sectionValue' => '05L',
				'dateString'   => '2017-12-29 02:02:21',
			],
			[
				'sectionValue' => 'FRIL',
				'dateString'   => '2017-12-29 02:02:21',
			],
			[
				'sectionValue' => 'friL',
				'dateString'   => '2017-12-29 02:02:21',
			],
			# Last Saturday in month
			[
				'sectionValue' => '6L',
				'dateString'   => '2017-12-30 02:02:21',
			],
			[
				'sectionValue' => '06L',
				'dateString'   => '2017-12-30 02:02:21',
			],
			[
				'sectionValue' => 'SATL',
				'dateString'   => '2017-12-30 02:02:21',
			],
			[
				'sectionValue' => 'satL',
				'dateString'   => '2017-12-30 02:02:21',
			],
			# Ranges
			[
				'sectionValue' => '1-5',
				'dateString'   => '2017-12-25 02:02:21',
			],
			[
				'sectionValue' => '1-5',
				'dateString'   => '2017-12-26 02:02:21',
			],
			[
				'sectionValue' => '1-5',
				'dateString'   => '2017-12-27 02:02:21',
			],
			[
				'sectionValue' => '1-5',
				'dateString'   => '2017-12-28 02:02:21',
			],
			[
				'sectionValue' => '1-5',
				'dateString'   => '2017-12-29 02:02:21',
			],
			# Ranges with steps
			[
				'sectionValue' => '1-5/2',
				'dateString'   => '2017-12-25 02:02:21',
			],
			[
				'sectionValue' => '1-5/2',
				'dateString'   => '2017-12-27 02:02:21',
			],
			[
				'sectionValue' => '1-5/2',
				'dateString'   => '2017-12-29 02:02:21',
			],
			# Lists
			[
				'sectionValue' => '1,WED,5,0',
				'dateString'   => '2017-12-25 02:02:21',
			],
			[
				'sectionValue' => '1,3,fri,0',
				'dateString'   => '2017-12-27 02:02:21',
			],
			[
				'sectionValue' => 'Mon,3,5,0',
				'dateString'   => '2017-12-29 02:02:21',
			],
			[
				'sectionValue' => '1,3,5,SuN',
				'dateString'   => '2017-12-31 02:02:21',
			],
			# Lists with numbers
			[
				'sectionValue' => '1#1,FRI#3',
				'dateString'   => '2017-12-04 02:02:21',
			],
			[
				'sectionValue' => '1#1,FRI#3',
				'dateString'   => '2017-12-15 02:02:21',
			],
			# Lists with last days in months
			[
				'sectionValue' => '1L,FRIL',
				'dateString'   => '2017-12-25 02:02:21',
			],
			[
				'sectionValue' => '1L,FRIL',
				'dateString'   => '2017-12-29 02:02:21',
			],
		];
	}
}
