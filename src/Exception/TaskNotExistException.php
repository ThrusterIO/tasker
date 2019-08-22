<?php

declare(strict_types=1);

namespace Thruster\Tasker\Exception;

use InvalidArgumentException;

/**
 * Class TaskNotExistException
 *
 * @package Thruster\Tasker\Exception
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
class TaskNotExistException extends InvalidArgumentException
{
    public function __construct(string $name)
    {
        parent::__construct(
            sprintf('Task "%s" does not exists.', $name)
        );
    }
}
