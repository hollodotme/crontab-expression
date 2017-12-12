<?php declare(strict_types=1);
/**
 * @author h.woltersdorf
 */

namespace hollodotme\CrontabExpression\Tests\Unit\Sections;

use hollodotme\CrontabExpression\Sections\MinuteSection;
use PHPUnit\Framework\TestCase;

final class MinuteSectionTest extends TestCase
{
	/**
	 * @param string $sectionValue
	 * @param string $dateString
	 *
	 * @dataProvider dueMinutesProvider
	 */
	public function testIsSatisfiedBy( string $sectionValue, string $dateString )
	{
		$minuteSection = new MinuteSection( $sectionValue );
		$dateTime      = new \DateTimeImmutable( $dateString );

		$this->assertTrue( $minuteSection->isSatisfiedBy( $dateTime ) );
	}

	public function dueMinutesProvider() : array
	{
		return [
			[
				'sectionValue' => '*',
				'dateString'   => '2017-12-12 13:53:21',
			],
			# Steps
			[
				'sectionValue' => '*/2',
				'dateString'   => '2017-12-12 13:02:21',
			],
			[
				'sectionValue' => '*/2',
				'dateString'   => '2017-12-12 13:54:21',
			],
			[
				'sectionValue' => '1',
				'dateString'   => '2017-12-12 13:01:21',
			],
			[
				'sectionValue' => '02',
				'dateString'   => '2017-12-12 13:02:21',
			],
			[
				'sectionValue' => '12',
				'dateString'   => '2017-12-12 13:12:21',
			],
			# Lists
			[
				'sectionValue' => '12,22,44',
				'dateString'   => '2017-12-12 13:12:21',
			],
			[
				'sectionValue' => '12,22,44',
				'dateString'   => '2017-12-12 13:22:21',
			],
			[
				'sectionValue' => '12,22,44',
				'dateString'   => '2017-12-12 13:44:21',
			],
			# Ranges
			[
				'sectionValue' => '12-22',
				'dateString'   => '2017-12-12 13:18:21',
			],
			[
				'sectionValue' => '12-22',
				'dateString'   => '2017-12-12 13:12:21',
			],
			[
				'sectionValue' => '12-22',
				'dateString'   => '2017-12-12 13:22:21',
			],
			# List with ranges
			[
				'sectionValue' => '12-22,32-44',
				'dateString'   => '2017-12-12 13:18:21',
			],
			[
				'sectionValue' => '12-22,32-44',
				'dateString'   => '2017-12-12 13:33:21',
			],
			[
				'sectionValue' => '12-22,32-44',
				'dateString'   => '2017-12-12 13:44:21',
			],
			# Ranges with steps
			[
				'sectionValue' => '12-22/2',
				'dateString'   => '2017-12-12 13:14:21',
			],
			[
				'sectionValue' => '12-22/2',
				'dateString'   => '2017-12-12 13:16:21',
			],
			[
				'sectionValue' => '12-22/2',
				'dateString'   => '2017-12-12 13:14:21',
			],
			[
				'sectionValue' => '12-22/2',
				'dateString'   => '2017-12-12 13:16:21',
			],
			# List with ranges and steps
			[
				'sectionValue' => '12-22/2,32-44/4',
				'dateString'   => '2017-12-12 13:36:21',
			],
			[
				'sectionValue' => '12-22/2,32-44/4',
				'dateString'   => '2017-12-12 13:36:21',
			],
		];
	}
}
