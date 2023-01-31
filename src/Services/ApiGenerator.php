<?php

namespace TomatoPHP\TomatoApi\Services;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use TomatoPHP\TomatoApi\Services\Concerns\GenerateController;
use TomatoPHP\TomatoApi\Services\Concerns\GenerateFields;
use TomatoPHP\TomatoApi\Services\Concerns\GenerateInterface;
use TomatoPHP\TomatoApi\Services\Concerns\GenerateModel;
use TomatoPHP\TomatoApi\Services\Concerns\GenerateName;
use TomatoPHP\TomatoApi\Services\Concerns\GenerateRepository;
use TomatoPHP\TomatoApi\Services\Concerns\GenerateResource;
use TomatoPHP\TomatoApi\Services\Concerns\GenerateRoutes;
use TomatoPHP\TomatoApi\Services\Concerns\GenerateValidation;
use TomatoPHP\ConsoleHelpers\Traits\HandleStub;

class ApiGenerator
{
    use GenerateFields;
    use GenerateName;
    use GenerateInterface;
    use GenerateRepository;
    use GenerateValidation;
    use GenerateController;
    use GenerateRoutes;
    use GenerateResource;
    use GenerateModel;

    use HandleStub;

    private Connection $connection;
    private string $stub;
    private string $model;

    public function __construct(
        private string $table,
        private string | bool | null $module
    )
    {
        $connectionParams = [
            'dbname' => config('database.connections.mysql.database'),
            'user' => config('database.connections.mysql.username'),
            'password' => config('database.connections.mysql.password'),
            'host' => config('database.connections.mysql.host'),
            'driver' => 'pdo_mysql',
        ];

        $this->connection = DriverManager::getConnection($connectionParams);
        $this->stub = __DIR__ .'/../../stubs/';
        $this->model = $this->generateName(true, true, false);
    }

    /**
     * @return void
     */
    public function generate(): void
    {
        $this->generateModel();
        $this->generateInterface();
        $this->generateRepository();
        $this->generateValidation();
        $this->generateController();
        $this->generateRoutes();
        $this->generateResource();
    }
}
