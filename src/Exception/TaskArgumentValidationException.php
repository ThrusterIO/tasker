<?php

declare(strict_types=1);

namespace Thruster\Tasker\Exception;

use InvalidArgumentException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class TaskArgumentValidationException extends InvalidArgumentException
{
    /** @var array */
    private $errors;

    /** @var ConstraintViolationListInterface */
    private $constraintViolationList;

    public function __construct(ConstraintViolationListInterface $constraintViolationList)
    {
        $this->errors                  = [];
        $this->constraintViolationList = $constraintViolationList;

        $errorString = '';
        /** @var ConstraintViolationInterface $constraintViolation */
        foreach ($constraintViolationList as $constraintViolation) {
            $fieldErrors[] = [
                'field'   => $constraintViolation->getPropertyPath(),
                'code'    => $constraintViolation->getCode(),
                'message' => $constraintViolation->getMessage(),
            ];

            $errorString .= ' Field: "' . $constraintViolation->getPropertyPath() .
                '" Error: "' . $constraintViolation->getMessage() . '",';
        }

        parent::__construct('Task Argument Validation Error' . rtrim($errorString, ','));
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getConstraintViolationList(): ConstraintViolationListInterface
    {
        return $this->constraintViolationList;
    }
}
