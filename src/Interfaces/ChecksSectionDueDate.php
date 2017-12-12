<?php declare(strict_types=1);
/**
 * @author h.woltersdorf
 */

namespace hollodotme\CrontabExpression\Interfaces;

/**
 * Interface ChecksSectionDueDate
 * @package hollodotme\CrontabExpression\Interfaces
 */
interface ChecksSectionDueDate
{
	public function isSatisfiedBy( \DateTimeInterface $dateTime ) : bool;
}
