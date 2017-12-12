<?php declare(strict_types=1);
/**
 * @author h.woltersdorf
 */

namespace hollodotme\CrontabExpression\Sections;

/**
 * Class MinuteSection
 * @package hollodotme\CrontabExpression\Sections
 */
final class MinuteSection extends AbstractSection
{
	public function isSatisfiedBy( \DateTimeInterface $dateTime ) : bool
	{
		$checkValue = $this->replaceAsterisk( '0-59' );

		$satisfied = false;

		foreach ( $this->getList( $checkValue ) as $listValue )
		{
			$satisfied = $satisfied || $this->isListValueSatisfiedBy( $listValue, $dateTime );
		}

		return $satisfied;
	}

	private function isListValueSatisfiedBy( string $listValue, \DateTimeInterface $dateTime ) : bool
	{
		if ( preg_match( '#^[0-5]?\d$#', $listValue ) )
		{
			return (int)$listValue === (int)$dateTime->format( 'i' );
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
		return \in_array( (int)$dateTime->format( 'i' ), $range, true );
	}
}
