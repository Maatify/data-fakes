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
