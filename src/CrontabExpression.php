<?php declare(strict_types=1);
/**
 * @author h.woltersdorf
 */

namespace hollodotme\CrontabExpression;

use hollodotme\CrontabExpression\Interfaces\ChecksSectionDueDate;
use hollodotme\CrontabExpression\Sections\SectionFactory;
use hollodotme\CrontabValidator\CrontabValidator;

/**
 * Class CrontabExpression
 * @package hollodotme\CrontabExpression
 */
class CrontabExpression
{
	/** @var array|ChecksSectionDueDate[] */
	private $sections;

	public function __construct( string $expression )
	{
		$this->guardExpressionIsValid( $expression );

		$this->initSections( $expression );
	}

	private function guardExpressionIsValid( string $expression ) : void
	{
		(new CrontabValidator())->guardExpressionIsValid( $expression );
	}

	private function initSections( string $expression ) : void
	{
		$sectionValues  = preg_split( "#\s+#", $expression, -1, PREG_SPLIT_NO_EMPTY );
		$sectionFactory = new SectionFactory();

		foreach ( $sectionValues as $sectionType => $sectionValue )
		{
			$this->sections[ (int)$sectionType ] = $sectionFactory->getSection(
				(int)$sectionType,
				trim( $sectionValue )
			);
		}
	}

	public function isDue( ?\DateTimeInterface $dateTime = null ) : bool
	{
		if ( null === $dateTime )
		{
			$dateTime = new \DateTimeImmutable();
		}

		foreach ( $this->sections as $section )
		{
			if ( !$section->isSatisfiedBy( $dateTime ) )
			{
				return false;
			}
		}

		return true;
	}
}
