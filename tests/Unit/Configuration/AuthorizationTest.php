<?php

declare(strict_types=1);

namespace Test\Unit\Configuration;

use Casbin\Enforcer;
use Casbin\Exceptions\CasbinException;
use CasbinAdapter\DBAL\Adapter;
use PHPUnit\Framework\TestCase;
use Casbin\Model\Model;
use Psr\Container\ContainerInterface;
use Test\Unit\Configuration\Mock\UserMock;

/**
 * @internal
 */
final class AuthorizationTest extends TestCase
{
    /**
     * @throws CasbinException
     */
    public function testACL(): void
    {
        /** @var ContainerInterface $container */
        $container = require __DIR__ . '/../../../configuration/main/container.php';

        $adapter = $container->get(Adapter::class);

        $queryBuilder = $adapter->getConnection()->createQueryBuilder();
        /** @psalm-suppress DeprecatedMethod */
        $queryBuilder->delete($adapter->policyTableName)->where('1 = 1')->execute();

        $data = [
            // тип, субъект, ресурс, доступ
            ['p_type' => 'p', 'v0' => 'alex', 'v1' => 'adminpanel','v2' => 'read'],
            ['p_type' => 'p', 'v0' => 'alex', 'v1' => 'adminpanel','v2' => 'write'],
            ['p_type' => 'p', 'v0' => 'user123', 'v1' => 'adminpanel','v2' => 'write'],
            ['p_type' => 'p', 'v0' => 'user456', 'v1' => 'adminpanel','v2' => 'write'],
            ['p_type' => 'p', 'v0' => 'user789', 'v1' => 'adminpanel','v2' => 'write']
        ];
        foreach ($data as $row) {
            $keys = array_keys($row);
            $count = count($row);
            $fill = array_fill(0, $count, '?');
            $combine = array_combine($keys, $fill);
            $values = array_values($row);
            /** @psalm-suppress DeprecatedMethod */
            $queryBuilder->insert($adapter->policyTableName)->values($combine)->setParameters($values)->execute();
        }
        $model = Model::newModelFromString(
            <<<'EOT'
[request_definition]
r = sub, obj, act

[policy_definition]
p = sub, obj, act

[policy_effect]
e = some(where (p.eft == allow))

[matchers]
m = r.sub == p.sub && r.obj == p.obj && r.act == p.act
EOT
        );

        $enforcer = new Enforcer($model, $adapter);
        self::assertTrue($enforcer->enforce('alex','adminpanel','write'));
        self::assertFalse($enforcer->enforce('tanya','adminpanel','write'));
    }

    /**
     * @throws CasbinException
     */
    public function testRBAC(): void
    {
        /** @var ContainerInterface $container */
        $container = require __DIR__ . '/../../../configuration/main/container.php';

        $adapter = $container->get(Adapter::class);

        $queryBuilder = $adapter->getConnection()->createQueryBuilder();
        /** @psalm-suppress DeprecatedMethod */
        $queryBuilder->delete($adapter->policyTableName)->where('1 = 1')->execute();

        $data = [
            // тип, субъект, ресурс, доступ
            ['p_type' => 'g', 'v0' => 'alex', 'v1' => 'admin'],
            ['p_type' => 'g', 'v0' => 'alice', 'v1' => 'moderator'],
            ['p_type' => 'g', 'v0' => 'bob', 'v1' => 'writer'],
            ['p_type' => 'g', 'v0' => 'admin', 'v1' => 'moderator'],
            ['p_type' => 'g', 'v0' => 'moderator', 'v1' => 'writer'],
            ['p_type' => 'p', 'v0' => 'admin', 'v1' => 'client', 'v2' => 'delete'],
            ['p_type' => 'p', 'v0' => 'moderator', 'v1' => 'client', 'v2' => 'modify'],
            ['p_type' => 'p', 'v0' => 'writer', 'v1' => 'client', 'v2' => 'read'],
        ];
        foreach ($data as $row) {
            $keys = array_keys($row);
            $count = count($row);
            $fill = array_fill(0, $count, '?');
            $combine = array_combine($keys, $fill);
            $values = array_values($row);
            /** @psalm-suppress DeprecatedMethod */
            $queryBuilder->insert($adapter->policyTableName)->values($combine)->setParameters($values)->execute();
        }
        $model = Model::newModelFromString(
            <<<'EOT'
[request_definition]
r = sub, obj, act

[policy_definition]
p = sub, obj, act

[role_definition]
g = _, _

[policy_effect]
e = some(where (p.eft == allow))

[matchers]
m = g(r.sub, p.sub) && r.obj == p.obj && r.act == p.act
EOT
        );

        $enforcer = new Enforcer($model, $adapter);
        self::assertTrue($enforcer->enforce('alex','client','delete'));
        self::assertTrue($enforcer->enforce('bob','client','read'));
    }

    /**
     * @throws CasbinException
     */
    public function testABAC(): void
    {
        /** @var ContainerInterface $container */
        $container = require __DIR__ . '/../../../configuration/main/container.php';

        $adapter = $container->get(Adapter::class);

        $queryBuilder = $adapter->getConnection()->createQueryBuilder();
        /** @psalm-suppress DeprecatedMethod */
        $queryBuilder->delete($adapter->policyTableName)->where('1 = 1')->execute();

        $data = [
            // тип, субъект, ресурс, доступ
            ['p_type' => 'p', 'v0' => 'r.sub.age > 18 && r.sub.age < 30', 'v1' => 'data', 'v2' => 'read'],
            ['p_type' => 'p', 'v0' => 'r.sub.age > 40', 'v1' => 'data', 'v2' =>  'write']
        ];
        foreach ($data as $row) {
            $keys = array_keys($row);
            $count = count($row);
            $fill = array_fill(0, $count, '?');
            $combine = array_combine($keys, $fill);
            $values = array_values($row);
            /** @psalm-suppress DeprecatedMethod */
            $queryBuilder->insert($adapter->policyTableName)->values($combine)->setParameters($values)->execute();
        }
        $model = Model::newModelFromString(
            <<<'EOT'
[request_definition]
r = sub, obj, act

[policy_definition]
p = sub_rule, obj, act

[policy_effect]
e = some(where (p.eft == allow))

[matchers]
m = eval(p.sub_rule) && r.obj == p.obj && r.act == p.act
EOT
        );

        $enforcer = new Enforcer($model, $adapter);

        $user = new UserMock('2', '22');
        self::assertTrue($enforcer->enforce($user,'data','read'));
    }

    /**
     * @throws CasbinException
     */
    public function testMyRbac(): void {
        /** @var ContainerInterface $container */
        $container = require __DIR__ . '/../../../configuration/main/container.php';

        $adapter = $container->get(Adapter::class);

        $queryBuilder = $adapter->getConnection()->createQueryBuilder();
        /** @psalm-suppress DeprecatedMethod */
        $queryBuilder->delete($adapter->policyTableName)->where('1 = 1')->execute();

        $data = [
            // тип, субъект, ресурс, доступ
            ['p_type' => 'g', 'v0' => '1', 'v1' => 'admin'],
            ['p_type' => 'g', 'v0' => '2', 'v1' => 'moderator'],
            ['p_type' => 'g', 'v0' => '3', 'v1' => 'priv'],
            ['p_type' => 'g', 'v0' => '4', 'v1' => 'user'],
            ['p_type' => 'g', 'v0' => '5', 'v1' => 'delete'],

            ['p_type' => 'g', 'v0' => 'admin', 'v1' => 'moderator'],
            ['p_type' => 'g', 'v0' => 'moderator', 'v1' => 'priv'],
            ['p_type' => 'g', 'v0' => 'priv', 'v1' => 'user'],
            ['p_type' => 'g', 'v0' => 'user', 'v1' => 'delete'],

            ['p_type' => 'p', 'v0' => 'admin', 'v1' => 'auth.user', 'v2' => 'delete'],
            ['p_type' => 'p', 'v0' => 'moderator', 'v1' => 'auth.user', 'v2' => 'change_role'],
            ['p_type' => 'p', 'v0' => 'moderator', 'v1' => 'auth.user', 'v2' => 'register'],
            ['p_type' => 'p', 'v0' => 'moderator', 'v1' => 'auth.user', 'v2' => 'change_password'],
            ['p_type' => 'p', 'v0' => 'user', 'v1' => 'auth.user', 'v2' => 'read_profile'],
        ];
        foreach ($data as $row) {
            $keys = array_keys($row);
            $count = count($row);
            $fill = array_fill(0, $count, '?');
            $combine = array_combine($keys, $fill);
            $values = array_values($row);
            /** @psalm-suppress DeprecatedMethod */
            $queryBuilder->insert($adapter->policyTableName)->values($combine)->setParameters($values)->execute();
        }
        $model = Model::newModelFromString(
            <<<'EOT'
[request_definition]
r = sub, obj, act

[policy_definition]
p = sub, obj, act

[role_definition]
g = _, _

[policy_effect]
e = some(where (p.eft == allow))

[matchers]
m = g(r.sub, p.sub) && r.obj == p.obj && r.act == p.act
EOT
        );

        $enforcer = new Enforcer($model, $adapter);
        self::assertTrue($enforcer->enforce('1','auth.user','delete'));
        self::assertTrue($enforcer->enforce('1','auth.user','change_password'));
        self::assertFalse($enforcer->enforce('5','auth.user','change_password'));
    }
}