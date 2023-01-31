<?php

namespace TomatoPHP\TomatoApi\Services\Concerns;

use Illuminate\Support\Str;

trait GenerateRoutes
{
    /**
     * @return void
     */
    private function generateRoutes(): void
    {
        $routePath = $this->module ?  module_path($this->module) .'/Routes/' : base_path('/routes') ;

        $this->generateStubs(
            $this->stub . "route.stub",
            $routePath . '/api.php',
            [
                "path" => $this->module ? 'Modules\\'.$this->module : 'App',
                "model" => $this->model,
                "table" => Str::lcfirst(Str::studly($this->table)),
                "name" => $this->table
            ],
            [
                $routePath
            ],
            true
        );
    }
}
