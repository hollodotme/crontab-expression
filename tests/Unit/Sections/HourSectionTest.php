<?php declare(strict_types=1);
/**
 * @author h.woltersdorf
 */

namespace hollodotme\CrontabExpression\Tests\Unit\Sections;

use hollodotme\CrontabExpression\Sections\HourSection;
use PHPUnit\Framework\TestCase;

/**
 * Class HourSectionTest
 * @package hollodotme\CrontabExpression\Tests\Unit\Sections
 */
final class HourSectionTest extends TestCase
{
	/**
	 * @param string $sectionValue
	 * @param string $dateString
	 *
	 * @dataProvider dueHoursProvider
	 */
	public function testIsSatisfiedBy( string $sectionValue, string $dateString )
	{
		$hourSection = new HourSection( $sectionValue );
		$dateTime      = new \DateTimeImmutable( $dateString );

		$this->assertTrue( $hourSection->isSatisfiedBy( $dateTime ) );
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
				'dateString'   => '2017-12-12 02:02:21',
			],
			[
				'sectionValue' => '*/2',
				'dateString'   => '2017-12-12 10:54:21',
			],
			[
				'sectionValue' => '1',
				'dateString'   => '2017-12-12 01:01:21',
			],
			[
				'sectionValue' => '02',
				'dateString'   => '2017-12-12 02:02:21',
			],
			[
				'sectionValue' => '23',
				'dateString'   => '2017-12-12 23:12:21',
			],
			# Lists
			[
				'sectionValue' => '0,3,22',
				'dateString'   => '2017-12-12 00:12:21',
			],
			[
				'sectionValue' => '0,3,22',
				'dateString'   => '2017-12-12 03:22:21',
			],
			[
				'sectionValue' => '00,3,22',
				'dateString'   => '2017-12-12 22:44:21',
			],
			# Ranges
			[
				'sectionValue' => '12-22',
				'dateString'   => '2017-12-12 12:18:21',
			],
			[
				'sectionValue' => '12-22',
				'dateString'   => '2017-12-12 13:12:21',
			],
			[
				'sectionValue' => '12-22',
				'dateString'   => '2017-12-12 22:22:21',
			],
			# List with ranges
			[
				'sectionValue' => '0-5,12-22',
				'dateString'   => '2017-12-12 02:18:21',
			],
			[
				'sectionValue' => '0-5,12-22',
				'dateString'   => '2017-12-12 13:33:21',
			],
			[
				'sectionValue' => '0-5,12-22',
				'dateString'   => '2017-12-12 19:44:21',
			],
			# Ranges with steps
			[
				'sectionValue' => '12-22/2',
				'dateString'   => '2017-12-12 14:14:21',
			],
			[
				'sectionValue' => '12-22/2',
				'dateString'   => '2017-12-12 16:16:21',
			],
			[
				'sectionValue' => '12-22/2',
				'dateString'   => '2017-12-12 18:14:21',
			],
			[
				'sectionValue' => '12-22/2',
				'dateString'   => '2017-12-12 22:16:21',
			],
			# List with ranges and steps
			[
				'sectionValue' => '0-6/3,12-22/2',
				'dateString'   => '2017-12-12 3:36:21',
			],
			[
				'sectionValue' => '0-6/3,12-22/2',
				'dateString'   => '2017-12-12 14:36:21',
			],
		];
	}
}
