<?php declare(strict_types=1);
/**
 * @author h.woltersdorf
 */

namespace hollodotme\CrontabExpression\Sections;

/**
 * Class DayOfMonthSection
 * @package hollodotme\CrontabExpression\Sections
 */
final class DayOfMonthSection extends AbstractSection
{
	public function isSatisfiedBy( \DateTimeInterface $dateTime ) : bool
	{
		$checkValue = $this->replaceAsterisk( '1-31' );
		$checkValue = $this->replaceQuestionMark( $checkValue );

		$satisfied = false;

		foreach ( $this->getList( $checkValue ) as $listValue )
		{
			$satisfied = $satisfied || $this->isListValueSatisfiedBy( $listValue, $dateTime );
		}

		return $satisfied;
	}

	private function replaceQuestionMark( string $value ) : string
	{
		return str_replace( '?', '1-31', $value );
	}

	private function isListValueSatisfiedBy( string $listValue, \DateTimeInterface $dateTime ) : bool
	{
		if ( $listValue === 'L' )
		{
			return ($dateTime->format( 'd' ) === $dateTime->format( 't' ));
		}

		if ( preg_match( '#^(0?[1-9]|[12]\d|3[01])$#', $listValue ) )
		{
			return (int)$listValue === (int)$dateTime->format( 'd' );
		}

		if ( $listValue[ -1 ] === 'W' )
		{
			$day = substr( $listValue, 0, -1 );

			return $this->isWeekDaySatisfiedBy( $day, $dateTime );
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
		return \in_array( (int)$dateTime->format( 'd' ), $range, true );
	}

	private function isWeekDaySatisfiedBy( string $day, \DateTimeInterface $dateTime ) : bool
	{
		if ( !\in_array( (int)$dateTime->format( 'w' ), range( 1, 5 ), true ) )
		{
			return false;
		}

		if ( (int)$day === (int)$dateTime->format( 'd' ) )
		{
			return true;
		}

		$checkDate    = new \DateTime( sprintf( '%s-%02d', $dateTime->format( 'Y-m' ), $day ) );
		$checkWeekDay = (int)$checkDate->format( 'w' );

		# If day is Sunday and last of month, check for previous friday
		if ( $checkWeekDay === 0 && (int)$checkDate->format( 't' ) === (int)$day )
		{
			$checkDate->modify( 'previous friday' );
		}

		# On Sunday or on first of month, check for next monday
		elseif ( $checkWeekDay === 0 || (int)$day === 1 )
		{
			$checkDate->modify( 'next monday' );
		}

		# On Saturday check for previous friday, if not first of month
		if ( $checkWeekDay === 6 && (int)$day !== 1 )
		{
			$checkDate->modify( 'previous friday' );
		}

		return ($checkDate->format( 'd' ) === $dateTime->format( 'd' ));
	}
}
