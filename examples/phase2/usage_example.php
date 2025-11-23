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
