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
