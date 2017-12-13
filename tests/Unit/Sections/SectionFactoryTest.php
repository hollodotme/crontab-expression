<?php declare(strict_types=1);
/**
 * @author h.woltersdorf
 */

namespace hollodotme\CrontabExpression\Tests\Unit\Sections;

use hollodotme\CrontabExpression\Exceptions\LogicException;
use hollodotme\CrontabExpression\Sections\DayOfMonthSection;
use hollodotme\CrontabExpression\Sections\DayOfWeekSection;
use hollodotme\CrontabExpression\Sections\HourSection;
use hollodotme\CrontabExpression\Sections\MinuteSection;
use hollodotme\CrontabExpression\Sections\MonthSection;
use hollodotme\CrontabExpression\Sections\SectionFactory;
use hollodotme\CrontabExpression\Sections\SectionType;
use PHPUnit\Framework\TestCase;

/**
 * Class SectionFactoryTest
 * @package hollodotme\CrontabExpression\Tests\Unit\Sections
 */
final class SectionFactoryTest extends TestCase
{
	/**
	 * @param int    $sectionType
	 * @param string $expectedClassName
	 *
	 * @dataProvider sectionTypeAndValueProvider
	 */
	public function testCanGetSectionInstanceWithTypeAndValue( int $sectionType, string $expectedClassName ) : void
	{
		$sectionFactory = new SectionFactory();
		$section        = $sectionFactory->getSection( $sectionType, '*' );

		$this->assertInstanceOf( $expectedClassName, $section );
	}

	public function sectionTypeAndValueProvider() : array
	{
		return [
			[
				'sectionType'       => SectionType::SECTION_MINUTE,
				'expectedClassName' => MinuteSection::class,
			],
			[
				'sectionType'       => SectionType::SECTION_HOUR,
				'expectedClassName' => HourSection::class,
			],
			[
				'sectionType'       => SectionType::SECTION_DAY_OF_MONTH,
				'expectedClassName' => DayOfMonthSection::class,
			],
			[
				'sectionType'       => SectionType::SECTION_MONTH,
				'expectedClassName' => MonthSection::class,
			],
			[
				'sectionType'       => SectionType::SECTION_DAY_OF_WEEK,
				'expectedClassName' => DayOfWeekSection::class,
			],
		];
	}

	public function testThrowsExceptionForUnknownSectionType() : void
	{
		$this->expectException( LogicException::class );

		$sectionFactory = new SectionFactory();
		$sectionFactory->getSection( 42, '*' );
	}
}
