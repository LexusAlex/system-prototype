<?php

declare(strict_types=1);

namespace Test\Unit\Configuration;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Test\Unit\Configuration\Mock\CommandMock;

/**
 * @internal
 */
final class ValidatorTest extends TestCase
{
    public function testCheckCommand(): void
    {
        /** @var ContainerInterface $container */
        $container = require __DIR__ . '/../../../configuration/main/container.php';
        $validator = $container->get(ValidatorInterface::class);

        $command = $this->createMock(CommandMock::class);
        $command->email = 'a@b.ru';
        $command->password = '123456';
        $command->equals = 'NoTest';

        $violations = $validator->validate($command);

        if (count($violations) > 0) {
            $errors = [];
            /** @var ConstraintViolationInterface $violation */
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
            self::assertEquals('This value should be equal to "Test".', $errors['equals']);
        }
    }
}
