<?php declare(strict_types=1);
/**
 * @author h.woltersdorf
 */

namespace hollodotme\CrontabExpression\Sections;

use hollodotme\CrontabExpression\Interfaces\ChecksSectionDueDate;

/**
 * Class AbstractSection
 * @package hollodotme\CrontabExpression\Sections
 */
abstract class AbstractSection implements ChecksSectionDueDate
{
	/** @var string */
	private $sectionValue;

	public function __construct( string $sectionValue )
	{
		$this->sectionValue = $sectionValue;
	}

	public function getSectionValue() : string
	{
		return $this->sectionValue;
	}

	final protected function replaceAsterisk( string $replacement ) : string
	{
		return str_replace( '*', $replacement, $this->sectionValue );
	}

	final protected function getList( string $value ) : array
	{
		return explode( ',', $value );
	}

	final protected function getStep( string $value ) : int
	{
		$parts = explode( '/', $value );

		return (\count( $parts ) === 2) ? (int)$parts[1] : 1;
	}

	final protected function removeStep( string $value ) : string
	{
		return preg_replace( '#/\d+$#', '', $value );
	}

	final protected function getNumber( string $value ) : int
	{
		$parts = explode( '#', $value );

		return (\count( $parts ) === 2) ? (int)$parts[1] : 0;
	}

	final protected function removeNumber( string $value ) : string
	{
		return preg_replace( '#\#\d+$#', '', $value );
	}

	final protected function isRange( string $value ) : bool
	{
		return (strpos( $value, '-' ) !== false);
	}

	final protected function getRange( string $value, int $step ) : array
	{
		[ $low, $high ] = explode( '-', $value );

		return range( (int)$low, (int)$high, $step );
	}
}
