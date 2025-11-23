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
