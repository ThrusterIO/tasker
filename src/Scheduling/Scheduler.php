<?php

declare(strict_types=1);

namespace Thruster\Tasker\Scheduling;

use DateTimeInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Class Scheduler
 *
 * @package Thruster\Tasker\Scheduling
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class Scheduler
{
    /** @var EventProviderInterface */
    private $eventProvider;

    /** @var ScheduledTaskRunnerInterface */
    private $runner;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        EventProviderInterface $eventProvider,
        ScheduledTaskRunnerInterface $runner,
        LoggerInterface $logger = null
    ) {
        $this->eventProvider = $eventProvider;
        $this->runner        = $runner;
        $this->logger        = $logger ?? new NullLogger();
    }

    public function getDueEvents(DateTimeInterface $at): array
    {
        $events = [];

        foreach ($this->eventProvider->getScheduledEvents() as $scheduledEvent) {
            if (true === $scheduledEvent->isDue($at)) {
                $events[] = $scheduledEvent;
            }
        }

        return $events;
    }

    public function execute(DateTimeInterface $at): void
    {
        $this->logger->debug('Executing Scheduler', ['at' => $at]);

        $dueEvents = $this->getDueEvents($at);

        $this->logger->debug(
            'Scheduled Events found to execute',
            ['count' => count($dueEvents), 'at' => $at->format('Y-m-d H:i:s')]
        );

        foreach ($dueEvents as $dueEvent) {
            $this->logger->debug('Executing scheduled event', ['event' => $dueEvent]);

            $this->runner->run($dueEvent);

            $this->logger->debug('Executing scheduled event finished', ['event' => $dueEvent]);
        }
    }
}
