<?php declare(strict_types=1);
/**
 * @author h.woltersdorf
 */

namespace hollodotme\CrontabExpression\Sections;

/**
 * Class MonthSection
 * @package hollodotme\CrontabExpression\Sections
 */
final class MonthSection extends AbstractSection
{
	public function isSatisfiedBy( \DateTimeInterface $dateTime ) : bool
	{
		$checkValue = $this->replaceAsterisk( '1-12' );
		$checkValue = $this->replaceMonthNames( $checkValue );

		$satisfied = false;

		foreach ( $this->getList( $checkValue ) as $listValue )
		{
			$satisfied = $satisfied || $this->isListValueSatisfiedBy( $listValue, $dateTime );
		}

		return $satisfied;
	}

	private function replaceMonthNames( string $value ) : string
	{
		$search  = [ 'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC' ];
		$replace = range( 1, 12 );

		return str_replace( $search, $replace, $value );
	}

	private function isListValueSatisfiedBy( string $listValue, \DateTimeInterface $dateTime ) : bool
	{
		if ( preg_match( '#^(0?[1-9]|1[012])$#', $listValue ) )
		{
			return (int)$listValue === (int)$dateTime->format( 'm' );
		}

		$step       = $this->getStep( $listValue );
		$checkValue = $this->removeStep( $listValue );

		if ( $this->isRange( $checkValue ) )
		{
			return $this->isRangeSatisfiedBy( $this->getRange( $checkValue, $step ), $dateTime );
		}

		return false;
	}

	private function isRangeSatisfiedBy( array $range, \DateTimeInterface $dateTime ) : bool
	{
		return \in_array( (int)$dateTime->format( 'm' ), $range, true );
	}
}
