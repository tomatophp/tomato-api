<?php

namespace TomatoPHP\TomatoApi\Services\Concerns;

trait GenerateController
{
    /**
     * @return void
     */
    private function generateController(): void
    {
        $path = $this->module ? module_path($this->module) .'/Http/Controllers/Api' :  app_path('/Http/Controllers/Api');

        $this->generateStubs(
            $this->stub .'api.stub',
            $path . '/'. $this->model.'ApiController.php',
            [
                "path" => $this->module ? 'Modules\\'.$this->module : 'App',
                "model" => $this->model,
                "cols" => $this->generateRules(),
                "objectName" => lcfirst($this->model),
                "modelPath" => $this->module ? 'Modules\\'.$this->module.'\\Entities' : 'App\\Models',
            ],
            [
                $path
            ]
        );
    }
}
