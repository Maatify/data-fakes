<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use Maatify\DataFakes\Environment\FakeEnvironment;

$environment = new FakeEnvironment();
$environment->beforeTest();

$environment->loadFixtures([
    'mysql' => [
        'users' => [
            ['id' => 1, 'name' => 'Ada'],
            ['id' => 2, 'name' => 'Grace'],
        ],
    ],
    'mongo' => [
        'logs' => [
            ['_id' => 'a1', 'message' => 'booted'],
        ],
    ],
    'redis' => [
        'strings' => ['feature:flag' => true],
        'lists'   => ['jobs' => ['first', 'second']],
    ],
]);

$storage = $environment->getStorage();
$redis   = $environment->getRedis();
$mongo   = $environment->getMongo();

print_r([
    'mysqlUsers' => $storage->listAll('users'),
    'redisFlag'  => $redis->get('feature:flag'),
    'mongoLogs'  => $mongo->find('logs', []),
]);

// Reset between tests when auto-reset is enabled.
$environment->reset();
