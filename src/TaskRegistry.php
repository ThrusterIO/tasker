<?php

declare(strict_types=1);

namespace Thruster\Tasker;

use Doctrine\Common\Annotations\Annotation\Required;
use Symfony\Component\Validator\Constraints\Composite;
use Thruster\Tasker\Exception\TaskNotExistException;

/**
 * Class TaskRegistry
 *
 * @package Thruster\Tasker
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class TaskRegistry
{
    /** @var TaskInterface[] */
    private $tasks;

    public function __construct(iterable $tasks = [])
    {
        $this->tasks = [];

        foreach ($tasks as $task) {
            $this->addTask($task);
        }
    }

    public function addTask(TaskInterface $task): self
    {
        $this->tasks[$task::getName()] = $task;

        return $this;
    }

    public function hasTask(string $name): bool
    {
        return isset($this->tasks[$name]);
    }

    public function getTask(string $name): TaskInterface
    {
        if (false === $this->hasTask($name)) {
            throw new TaskNotExistException($name);
        }

        return $this->tasks[$name];
    }

    public function deleteTask(string $name): TaskInterface
    {
        $task = $this->getTask($name);

        unset($this->tasks[$name]);

        return $task;
    }

    public function all(): array
    {
        return $this->tasks;
    }

    public function allNames(): array
    {
        return array_keys($this->tasks);
    }

    public function taskDefinitions(): array
    {
        $result = [];

        foreach ($this->tasks as $task) {
            $params = [];

            foreach ($task->getArgumentSchema()->fields as $field => $constraints) {
                $params[$field] = [
                    'required'    => $constraints instanceof Required,
                    'constraints' => [],
                ];

                foreach ($constraints->constraints as $constraint) {
                    $params[$field]['constraints'][] = get_class($constraint);
                    if ($constraint instanceof Composite) {
                        foreach ($constraint->constraints as $allConstraint) {
                            $params[$field]['constraints'][] = get_class($allConstraint);
                        }
                    }
                }
            }

            $name          = $task::getName();
            $result[$name] = [
                'name'        => $name,
                'description' => $task->getDescription(),
                'params'      => $params,
            ];
        }

        return $result;
    }

    public function getTasksSchema(): array
    {
        $result = [];

        foreach ($this->tasks as $task) {
            $result[$task::getName()] = $task->getArgumentSchema();
        }

        return $result;
    }
}
