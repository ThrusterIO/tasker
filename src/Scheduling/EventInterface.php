<?php

declare(strict_types=1);

namespace Thruster\Tasker\Scheduling;

use DateTimeInterface;
use Thruster\Tasker\TaskInterface;

/**
 * Interface EventInterface
 *
 * @package Thruster\Tasker\Scheduling
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
interface EventInterface
{
    public function getName(): string;

    public function getDescription(): string;

    public function getTaskName(): string;

    public function getTaskArguments(): array;

    public function getSchedulerExpresion(): string;

    public function isDue(DateTimeInterface $at = null): bool;

    public function getNextRunDate(
        DateTimeInterface $current = null,
        int $nth = 0,
        bool $allowCurrentDate = false
    ): DateTimeInterface;
}
