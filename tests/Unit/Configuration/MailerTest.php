<?php

declare(strict_types=1);

namespace Test\Unit\Configuration;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Swift_Mailer;
use Swift_Message;
use Test\Functional\MailerClient;

/**
 * @internal
 */
final class MailerTest extends TestCase
{
    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testMessageSuccess(): void
    {
        /** @var ContainerInterface $container */
        $container = require __DIR__ . '/../../../configuration/main/container.php';
        $mailer = $container->get(Swift_Mailer::class);

        $message = (new Swift_Message('Test Message'))
            ->setTo('a@b.ru')
            ->setBody('Message string');

        self::assertEquals("Test Message", $message->getSubject());
        self::assertEquals(["a@b.ru" => null], $message->getTo());
        self::assertStringContainsString("Message string", $message->getBody());

        $client = new MailerClient();
        $client->clear();
        self::assertEquals(1,$mailer->send($message));
        self::assertTrue($client->hasEmailSentTo('a@b.ru'));
    }

    public function testMessageError(): void
    {
        /** @var ContainerInterface $container */
        $container = require __DIR__ . '/../../../configuration/main/container.php';
        $mailer = $container->get(Swift_Mailer::class);

        $message = (new Swift_Message('Test'));

        self::assertEquals(0,$mailer->send($message));
    }
}