<?php

declare(strict_types=1);

namespace Test\Unit\Configuration;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\Translation\Translator;

/**
 * @internal
 */
final class TranslatorTest extends TestCase
{
    public function testCheckTranslate(): void
    {
        /** @var ContainerInterface $container */
        $container = require __DIR__ . '/../../../configuration/main/container.php';
        $translator = $container->get(Translator::class);

        // Язык можно получать из заголовка Accept-Language
        $translator->setLocale('ru');

        $translate = $translator->trans('Incorrect token.',[], 'exceptions');

        self::assertEquals('Неверный токен.', $translate);
    }

    public function testNotLanguage(): void
    {
        /** @var ContainerInterface $container */
        $container = require __DIR__ . '/../../../configuration/main/container.php';
        $translator = $container->get(Translator::class);
        $translator->setLocale('AAAA');
        $translate = $translator->trans('This value should be false.',[], 'validators');

        self::assertEquals('This value should be false.', $translate);
    }
}
