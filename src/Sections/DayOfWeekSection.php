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
		return true;
	}
}
