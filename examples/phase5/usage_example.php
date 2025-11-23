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
