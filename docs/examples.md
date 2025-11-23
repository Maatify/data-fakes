# 📘 Maatify Data Fakes

**In-Memory Fake Adapters for MySQL, Redis, MongoDB & Repository Layer**  
**Version:** **1.0.4**  
**Project:** `maatify/data-fakes`  
**Maintained by:** Maatify.dev

---
# Examples
> This file is automatically synced with the examples found in `/examples/phase*/usage_example.php`.

This document contains usage examples for each phase of the **maatify/data-fakes** project.

## Phase 1 — FakeStorageLayer

```php
<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use Maatify\DataFakes\Storage\FakeStorageLayer;

$storage = new FakeStorageLayer();

// Insert a few rows with deterministic auto-increment IDs.
$firstUser  = $storage->write('users', ['name' => 'Ada Lovelace']);
$secondUser = $storage->write('users', ['name' => 'Alan Turing']);

// Read a single row by ID.
$readBack = $storage->readById('users', $firstUser['id']);

// Update a row and list all rows.
$storage->updateById('users', $secondUser['id'], ['name' => 'Grace Hopper']);
$allUsers = $storage->listAll('users');

// Export raw in-memory state for snapshotting or debugging.
$state = $storage->export();

print_r([
    'firstUser' => $firstUser,
    'readBack'  => $readBack,
    'allUsers'  => $allUsers,
    'state'     => $state,
]);

```

## Phase 2 — FakeMySQLAdapter & DBAL

```php
<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use Maatify\DataFakes\Adapters\MySQL\FakeMySQLAdapter;
use Maatify\DataFakes\Adapters\MySQL\FakeMySQLDbalAdapter;
use Maatify\DataFakes\Storage\FakeStorageLayer;

$storage   = new FakeStorageLayer();
$mysql     = new FakeMySQLAdapter($storage);
$dbal      = new FakeMySQLDbalAdapter($mysql);

$mysql->connect();

// Insert rows through the MySQL adapter.
$mysql->insert('users', ['name' => 'Ada Lovelace']);
$mysql->insert('users', ['name' => 'Alan Turing']);

// Query with filters and ordering.
$ordered = $mysql->select('users', [], ['orderBy' => 'name', 'order' => 'ASC']);

// Update and delete using filter matching.
$mysql->update('users', ['name' => 'Alan Turing'], ['name' => 'Grace Hopper']);
$mysql->delete('users', ['name' => 'Ada Lovelace']);

// Use the DBAL-style wrapper for single-row fetches.
$firstRow = $dbal->fetchOne('users', ['name' => 'Grace Hopper']);

print_r([
    'ordered'  => $ordered,
    'firstRow' => $firstRow,
    'all'      => $storage->listAll('users'),
]);

```

## Phase 3 — FakeRedisAdapter

```php
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

```

## Phase 4 — FakeMongoAdapter

```php
<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use Maatify\DataFakes\Adapters\Mongo\FakeMongoAdapter;
use Maatify\DataFakes\Storage\FakeStorageLayer;

$storage = new FakeStorageLayer();
$mongo   = new FakeMongoAdapter($storage);
$mongo->connect();

$mongo->insertOne('users', ['name' => 'Ada']);
$mongo->insertMany('users', [
    ['name' => 'Alan', 'language' => 'Turing complete'],
    ['name' => 'Grace', 'language' => 'COBOL'],
]);

$found   = $mongo->findOne('users', ['name' => 'Grace']);
$expensive = $mongo->find('users', ['price' => ['$gt' => 100]]); // empty example filter

$mongo->updateOne('users', ['name' => 'Ada'], ['language' => 'Analytics']);
$mongo->deleteOne('users', ['name' => 'Alan']);

print_r([
    'found'      => $found,
    'expensive'  => $expensive,
    'remaining'  => $storage->listAll('users'),
]);

```

## Phase 5 — Repository Layer

```php
<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use Maatify\DataFakes\Repository\Collections\FakeCollection;
use Maatify\DataFakes\Repository\FakeRepository;
use Maatify\DataFakes\Repository\Hydration\ArrayHydrator;
use Maatify\DataFakes\Storage\FakeStorageLayer;

$storage    = new FakeStorageLayer();
$hydrator   = new ArrayHydrator();
$repository = new FakeRepository($storage, 'users', $hydrator, ExampleUserDTO::class);

$id = $repository->insert(['name' => 'Ada Lovelace', 'role' => 'analyst']);
$repository->insert(['name' => 'Grace Hopper', 'role' => 'engineer']);

$single     = $repository->find($id);
$collection = $repository->findCollection();

print_r([
    'id'          => $id,
    'single'      => $single,
    'hydratedDTO' => $collection instanceof FakeCollection ? get_class($collection[0]) : null,
]);

final class ExampleUserDTO
{
    public int|string $id;
    public string $name;
    public string $role;
}

```

## Phase 6 — UnitOfWork & Snapshots

```php
<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use Maatify\DataFakes\Adapters\MySQL\FakeMySQLAdapter;
use Maatify\DataFakes\Repository\FakeUnitOfWork;
use Maatify\DataFakes\Storage\FakeStorageLayer;

$storage = new FakeStorageLayer();
$adapter = new FakeMySQLAdapter($storage);
$uow     = new FakeUnitOfWork($storage);

$adapter->connect();

// Manual begin/commit.
$uow->begin();
$adapter->insert('orders', ['status' => 'pending']);
$uow->commit();

// Transactional helper rolls back on exceptions.
try {
    $uow->transactional(function () use ($adapter): void {
        $adapter->insert('orders', ['status' => 'temporary']);
        throw new RuntimeException('Simulated failure');
    });
} catch (RuntimeException) {
    // Expected rollback
}

print_r([
    'orders' => $storage->listAll('orders'),
]);

```

## Phase 7 — Fixtures & FakeEnvironment

```php
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

```

## Phase 8 — Latency & Failure Simulation

```php
<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use Maatify\DataFakes\Adapters\MySQL\FakeMySQLAdapter;
use Maatify\DataFakes\Simulation\ErrorSimulator;
use Maatify\DataFakes\Simulation\FailureScenario;
use Maatify\DataFakes\Simulation\LatencySimulator;
use Maatify\DataFakes\Storage\FakeStorageLayer;
use Random\Engine\Mt19937;
use Random\Randomizer;

$randomizer = new Randomizer(new Mt19937(42));
$errorSim   = new ErrorSimulator($randomizer);
$latencySim = new LatencySimulator();
$latencySim->setDefaultLatency(2);
$latencySim->setOperationLatency('mysql.select', 5);

$errorSim->registerScenario(
    'mysql.insert',
    new FailureScenario('force failure', 1.0, RuntimeException::class, 'Simulated insert failure')
);

$storage = new FakeStorageLayer();
$storage->setLatencySimulator($latencySim);

$adapter = new FakeMySQLAdapter($storage);
$adapter->setErrorSimulator($errorSim);
$adapter->setLatencySimulator($latencySim);
$adapter->connect();

try {
    $adapter->insert('users', ['name' => 'should fail']);
} catch (RuntimeException $exception) {
    echo "Intercepted simulated failure: {$exception->getMessage()}" . PHP_EOL;
}

// Clear failures and proceed normally.
$errorSim->clearScenarios('mysql.insert');
$adapter->insert('users', ['name' => 'succeeds after clearing failures']);

print_r($storage->listAll('users'));

```

---

## 🪪 License

**[MIT license](../LICENSE)** © [Maatify.dev](https://www.maatify.dev)

---

## 👤 Author

Engineered by **Mohamed Abdulalim ([@megyptm](https://github.com/megyptm))**
[https://www.maatify.dev](https://www.maatify.dev)

📘 Full source:  
https://github.com/Maatify/data-fakes

---

<p align="center">
  <sub><span style="color:#777">Built with ❤️ by <a href="https://www.maatify.dev">Maatify.dev</a> — Unified Ecosystem for Modern PHP Libraries</span></sub>
</p>
