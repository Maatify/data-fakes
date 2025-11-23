<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use Maatify\DataFakes\Adapters\Redis\FakeRedisAdapter;

$redis = new FakeRedisAdapter();
$redis->connect();

$redis->set('cache:key', 'value', ttl: 60);
$redis->hset('hash:key', 'field', 'hash-value');
$redis->lpush('queue', 'first');
$redis->rpush('queue', 'second');
$counter = $redis->incr('counter');

print_r([
    'get'      => $redis->get('cache:key'),
    'hash'     => $redis->hget('hash:key', 'field'),
    'list'     => $redis->lrange('queue', 0, -1),
    'counter'  => $counter,
]);
