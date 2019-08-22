<?php

declare(strict_types=1);

namespace Thruster\Tasker\Scheduling;

/**
 * Interface EventProviderInterface
 *
 * @package Thruster\Tasker\Scheduling
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
interface EventProviderInterface
{
    /**
     * @return EventInterface[]
     */
    public function getScheduledEvents(): array;
}
