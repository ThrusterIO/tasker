<?php

declare(strict_types=1);

namespace Thruster\Tasker;

use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * Interface TaskInterface
 *
 * @package Thruster\Tasker
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
interface TaskInterface
{
    public static function getName(): string;

    public function getDescription(): string;

    public function getArgumentSchema(): Collection;

    public function setLogger(LoggerInterface $logger): TaskInterface;

    public function execute(array $arguments): void;
}
