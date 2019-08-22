<?php

declare(strict_types=1);

namespace Thruster\Tasker\Scheduling;

/**
 * Interface ScheduledTaskRunnerInterface
 *
 * @package Thruster\Tasker\Scheduling
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
interface ScheduledTaskRunnerInterface
{
    public function run(EventInterface $event): void;
}
