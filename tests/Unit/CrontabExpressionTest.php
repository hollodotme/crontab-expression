<?php declare(strict_types=1);
/**
 * @author h.woltersdorf
 */

namespace hollodotme\CrontabExpression\Tests\Unit;

use hollodotme\CrontabExpression\CrontabExpression;
use hollodotme\CrontabValidator\Exceptions\InvalidExpressionException;
use PHPUnit\Framework\TestCase;

/**
 * Class CrontabExpressionTest
 * @package hollodotme\CrontabExpression\Tests\Unit
 */
final class CrontabExpressionTest extends TestCase
{
	public function testCanCreateInstanceWithValidExpression() : void
	{
		$crontabExpression = new CrontabExpression( '* * * * *' );

		$this->assertInstanceOf( CrontabExpression::class, $crontabExpression );
	}

	public function testInvalidExpressionThrowsException() : void
	{
		$this->expectException( InvalidExpressionException::class );

		new CrontabExpression( 'a b c d e f' );
	}

	public function testCanCheckIfExpressionIsDueOnCurrentDate() : void
	{
		$this->assertTrue( (new CrontabExpression( '* * * * *' ))->isDue() );
		$this->assertTrue( (new CrontabExpression( '* * ? * ?' ))->isDue() );
	}

	/**
	 * @param string $expression
	 * @param string $dateString
	 *
	 * @dataProvider dueExpressionsProvider
	 */
	public function testCanCheckIfExpressionIsDue( string $expression, string $dateString ) : void
	{
		$crontabExpression = new CrontabExpression( $expression );
		$dateTime          = new \DateTimeImmutable( $dateString );

		$this->assertTrue( $crontabExpression->isDue( $dateTime ) );
	}

	public function dueExpressionsProvider() : array
	{
		return [
			[
				'expression' => '* * * * *',
				'dateString' => '2017-12-12 13:26:39',
			],
			[
				'expression' => '* * ? * ?',
				'dateString' => '2017-12-12 13:26:39',
			],
			[
				'expression' => '10-20/2 6-23 * 9-12 5#2',
				'dateString' => '2017-12-08 12:12:12',
			],
		];
	}
}
