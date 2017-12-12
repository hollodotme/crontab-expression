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
		return true;
	}
}
