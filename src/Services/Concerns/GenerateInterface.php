<?php

namespace TomatoPHP\TomatoApi\Services\Concerns;

trait GenerateInterface
{

    /**
     * @return void
     */
    private function generateInterface(): void
    {
        $interfacePath = $this->module ? module_path($this->module) .'/Interfaces' : app_path('/Interfaces') ;
        $this->generateStubs(
            $this->stub .'interface.stub',
            $interfacePath . '/'. $this->model.'RepositoryInterface.php',
            [
                "model" => $this->model,
                "namespace" => $this->module ? 'Modules\\'.$this->module.'\\Interfaces' : 'App\\Interfaces',
            ],
            [
                $interfacePath
            ]
        );
    }
}
