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
