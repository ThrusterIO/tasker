<?php

declare(strict_types=1);

namespace Thruster\Tasker\Scheduling;

use Cron\CronExpression;
use DateTimeInterface;

/**
 * Class AbstractEvent
 *
 * @package Thruster\Tasker\Scheduling
 * @author  Aurimas Niekis <aurimas@niekis.lt>
 */
abstract class AbstractEvent implements EventInterface
{
    /** @var CronExpression */
    protected $cronExpression;

    /**
     * @return CronExpression
     */
    public function getCronExpression(): CronExpression
    {
        if (null !== $this->cronExpression) {
            return $this->cronExpression;
        }

        $this->cronExpression = CronExpression::factory($this->getSchedulerExpresion());

        return $this->cronExpression;
    }

    public function isDue(DateTimeInterface $at = null): bool
    {
        return $this->getCronExpression()->isDue($at);
    }

    public function getNextRunDate(
        DateTimeInterface $current = null,
        int $nth = 0,
        bool $allowCurrentDate = false
    ): DateTimeInterface {
        return $this->getCronExpression()->getNextRunDate($current, $nth, $allowCurrentDate);
    }
}
