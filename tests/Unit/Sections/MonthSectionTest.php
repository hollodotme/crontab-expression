<?php declare(strict_types=1);
/**
 * @author h.woltersdorf
 */

namespace hollodotme\CrontabExpression\Tests\Unit\Sections;

use hollodotme\CrontabExpression\Sections\MonthSection;
use PHPUnit\Framework\TestCase;

/**
 * Class MonthSectionTest
 * @package hollodotme\CrontabExpression\Tests\Unit\Sections
 */
final class MonthSectionTest extends TestCase
{
	/**
	 * @param string $sectionValue
	 * @param string $dateString
	 *
	 * @dataProvider dueMonthsProvider
	 */
	public function testIsSatisfiedBy( string $sectionValue, string $dateString )
	{
		$monthSection = new MonthSection( $sectionValue );
		$dateTime      = new \DateTimeImmutable( $dateString );

		$this->assertTrue( $monthSection->isSatisfiedBy( $dateTime ) );
	}

	public function dueMonthsProvider() : array
	{
		return [
			[
				'sectionValue' => '*',
				'dateString'   => '2017-12-12 13:53:21',
			],
			# Steps
			[
				'sectionValue' => '*/2',
				'dateString'   => '2017-03-12 02:02:21',
			],
			[
				'sectionValue' => '*/2',
				'dateString'   => '2017-05-12 10:54:21',
			],
			[
				'sectionValue' => '1',
				'dateString'   => '2017-01-12 01:01:21',
			],
			[
				'sectionValue' => '02',
				'dateString'   => '2017-02-12 02:02:21',
			],
			[
				'sectionValue' => '12',
				'dateString'   => '2017-12-12 23:12:21',
			],
			# Lists
			[
				'sectionValue' => '1,3,10',
				'dateString'   => '2017-01-12 00:12:21',
			],
			[
				'sectionValue' => '1,3,10',
				'dateString'   => '2017-03-12 03:22:21',
			],
			[
				'sectionValue' => '01,3,10',
				'dateString'   => '2017-10-12 22:44:21',
			],
			# Ranges
			[
				'sectionValue' => '5-11',
				'dateString'   => '2017-05-12 12:18:21',
			],
			[
				'sectionValue' => '5-10',
				'dateString'   => '2017-07-12 13:12:21',
			],
			[
				'sectionValue' => '5-10',
				'dateString'   => '2017-10-12 22:22:21',
			],
			# List with ranges
			[
				'sectionValue' => '1-4,6-11',
				'dateString'   => '2017-01-12 02:18:21',
			],
			[
				'sectionValue' => '1-4,6-11',
				'dateString'   => '2017-03-12 13:33:21',
			],
			[
				'sectionValue' => '1-4,6-11',
				'dateString'   => '2017-04-12 19:44:21',
			],
			[
				'sectionValue' => '1-4,6-11',
				'dateString'   => '2017-06-12 02:18:21',
			],
			[
				'sectionValue' => '1-4,6-11',
				'dateString'   => '2017-08-12 13:33:21',
			],
			[
				'sectionValue' => '1-4,6-11',
				'dateString'   => '2017-11-12 19:44:21',
			],
			# Ranges with steps
			[
				'sectionValue' => '2-10/2',
				'dateString'   => '2017-02-12 14:14:21',
			],
			[
				'sectionValue' => '2-10/2',
				'dateString'   => '2017-04-12 16:16:21',
			],
			[
				'sectionValue' => '2-10/2',
				'dateString'   => '2017-08-12 18:14:21',
			],
			[
				'sectionValue' => '02-10/2',
				'dateString'   => '2017-10-12 22:16:21',
			],
			# List with ranges and steps
			[
				'sectionValue' => '1-7/3,08-12/2',
				'dateString'   => '2017-04-12 3:36:21',
			],
			[
				'sectionValue' => '1-7/3,08-12/2',
				'dateString'   => '2017-10-12 14:36:21',
			],
		];
	}
}
