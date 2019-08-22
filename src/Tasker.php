<?php

declare(strict_types=1);

namespace Thruster\Tasker;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Thruster\Tasker\Exception\TaskArgumentValidationException;
use Thruster\Tasker\Scheduling\EventInterface;
use Thruster\Tasker\Scheduling\ScheduledTaskRunnerInterface;

/**
 * Class Tasker
 *
 * @package Thruster\Tasker
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class Tasker implements ScheduledTaskRunnerInterface
{
    /** @var TaskRegistry */
    private $registry;

    /** @var LoggerInterface */
    private $logger;

    /** @var ValidatorInterface */
    private $validator;

    public function __construct(TaskRegistry $registry, ValidatorInterface $validator, LoggerInterface $logger = null)
    {
        $this->registry  = $registry;
        $this->validator = $validator;
        $this->logger    = $logger ?? new NullLogger();
    }

    public function execute(string $taskName, array $arguments = []): void
    {
        $task = $this->registry->getTask($taskName);

        $validationErrors = $this->validator->validate($arguments, $task->getArgumentSchema());

        if (count($validationErrors) > 0) {
            throw new TaskArgumentValidationException($validationErrors);
        }

        $this->logger->debug('Executing Task', ['task' => $taskName, 'args' => $arguments]);

        $task->execute($arguments);
    }

    public function run(EventInterface $event): void
    {
        $this->execute($event->getTaskName(), $event->getTaskArguments());
    }
}
