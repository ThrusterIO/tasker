<?php

declare(strict_types=1);

namespace Thruster\Tasker;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * Class BaseTask
 *
 * @package Thruster\Tasker
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
abstract class BaseTask implements TaskInterface
{
    /** @var LoggerInterface */
    protected $logger;

    public function getArgumentSchema(): Collection
    {
        return new Collection(['allowExtraFields' => true]);
    }

    public function setLogger(LoggerInterface $logger): TaskInterface
    {
        $this->logger = $logger;

        return $this;
    }

    public function getLogger(): LoggerInterface
    {
        if (null === $this->logger) {
            $this->logger = new NullLogger();
        }

        return $this->logger;
    }
}
