<?php

namespace TomatoPHP\TomatoApi\Services\Concerns;

use Illuminate\Support\Str;

trait GenerateRepository
{
    /**
     * @return void
     */
    private function generateRepository(): void
    {
        $repositoriesPath = $this->module ? module_path($this->module) .'/ApiRepositories' : app_path('/ApiRepositories');
        $this->generateStubs(
            $this->stub .'repository.stub',
            $repositoriesPath . '/'.$this->model.'Repository.php',
            [
                "path" => $this->module ? 'Modules\\'.$this->module : 'App',
                "model" => $this->model,
                "modelPath" => $this->module ? 'Modules\\'.$this->module.'\\Entities' : 'App\\Models',
                "table" => Str::studly(Str::lcfirst($this->table)),
                "name" => $this->table
            ],
            [
                $repositoriesPath
            ]
        );
    }
}
