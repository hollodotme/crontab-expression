<?php declare(strict_types=1);
/**
 * @author h.woltersdorf
 */

namespace hollodotme\CrontabExpression\Sections;

/**
 * Class DayOfWeekSection
 * @package hollodotme\CrontabExpression\Sections
 */
final class DayOfWeekSection extends AbstractSection
{
	public function isSatisfiedBy( \DateTimeInterface $dateTime ) : bool
	{
		$checkValue = $this->replaceAsterisk( '0-6' );
		$checkValue = $this->replaceQuestionMark( $checkValue );
		$checkValue = $this->replaceDayNames( $checkValue );
		$checkValue = $this->replaceSevenWithZero( $checkValue );

		$satisfied = false;

		foreach ( $this->getList( $checkValue ) as $listValue )
		{
			$satisfied = $satisfied || $this->isListValueSatisfiedBy( $listValue, $dateTime );
		}

		return $satisfied;
	}

	private function replaceQuestionMark( string $value ) : string
	{
		return str_replace( '?', '0-6', $value );
	}

	private function replaceDayNames( string $value ) : string
	{
		$search  = [ 'SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT' ];
		$replace = range( 0, 6 );

		return str_ireplace( $search, $replace, $value );
	}

	private function replaceSevenWithZero( string $value ) : string
	{
		return str_replace( '7', '0', $value );
	}

	private function isListValueSatisfiedBy( string $listValue, \DateTimeInterface $dateTime ) : bool
	{
		if ( preg_match( '#^(0?[0-6])$#', $listValue ) )
		{
			return (int)$listValue === (int)$dateTime->format( 'w' );
		}

		if ( $listValue[ -1 ] === 'L' )
		{
			$day = substr( $listValue, 0, -1 );

			return $this->isLastWeekDayInMonthSatisfiedBy( $day, $dateTime );
		}

		$step       = $this->getStep( $listValue );
		$checkValue = $this->removeStep( $listValue );

		$number     = $this->getNumber( $checkValue );
		$checkValue = $this->removeNumber( $checkValue );

		if ( 0 !== $number )
		{
			return $this->isNumberedDayInMonthSatisfiedBy( $checkValue, $number, $dateTime );
		}

		if ( $this->isRange( $checkValue ) )
		{
			return $this->isRangeSatisfiedBy( $this->getRange( $checkValue, $step ), $dateTime );
		}

		return false;
	}

	private function isLastWeekDayInMonthSatisfiedBy( string $day, \DateTimeInterface $dateTime ) : bool
	{
		$dayLiteral = $this->translateDayToLiteral( $day );

		$checkDate = new \DateTime( $dateTime->format( 'Y-m-d H:i:s' ) );
		$checkDate->modify( sprintf( 'last %s of this month', $dayLiteral ) );

		return $checkDate->format( 'Y-m-d' ) === $dateTime->format( 'Y-m-d' );
	}

	private function translateDayToLiteral( string $day ) : string
	{
		$days = [ 'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday' ];

		return $days[ (int)$day ];
	}

	private function isNumberedDayInMonthSatisfiedBy( string $day, int $number, \DateTimeInterface $dateTime ) : bool
	{
		$dayLiteral     = $this->translateDayToLiteral( $day );
		$numberLiterals = [ 'first', 'second', 'third', 'fourth', 'fifth' ];
		$numberLiteral  = $numberLiterals[ $number - 1 ];

		$checkDate = new \DateTime( $dateTime->format( 'Y-m-d H:i:s' ) );
		$checkDate->modify( sprintf( '%s %s of this month', $numberLiteral, $dayLiteral ) );

		return $checkDate->format( 'Y-m-d' ) === $dateTime->format( 'Y-m-d' );
	}

	private function isRangeSatisfiedBy( array $range, \DateTimeInterface $dateTime ) : bool
	{
		return \in_array( (int)$dateTime->format( 'w' ), $range, true );
	}
}
