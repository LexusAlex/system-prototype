<?php

declare(strict_types=1);

namespace Application\Infrastructure\Validator;

use LogicException;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

final class ValidationException extends LogicException
{
    /* @phpstan-ignore-next-line */
    private ConstraintViolationListInterface $violations;

    /* @phpstan-ignore-next-line */
    public function __construct(
        ConstraintViolationListInterface $violations,
        string $message = 'Invalid input.',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->violations = $violations;
    }
    /* @phpstan-ignore-next-line */
    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
