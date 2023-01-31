<?php

namespace TomatoPHP\TomatoApi\Services\Concerns;

use Illuminate\Support\Facades\Artisan;

trait GenerateModel
{
    /**
     * @return void
     */
    public function generateModel(): void
    {
        //Check if model exists or not

        $command = "config:clear";

        if($this->module){
            if(!file_exists(module_path($this->module) . '/Entities/'. $this->model . '.php')){
                $command = 'krlove:generate:model ' . $this->model . ' --table-name=' . $this->table . ' --output-path=' . module_path($this->module) . '/Entities' . ' --namespace=' . "Modules" . "\\\\" . $this->module . "\\\\" . "Entities";
            }
        }
        else if(!file_exists(app_path("Models/{$this->model}.php"))){
            $command = 'krlove:generate:model ' . $this->model . ' --table-name=' . $this->table . ' --output-path=' . app_path('/Models') . ' --namespace=' . "\\App\\\\Models\\";
        }

        Artisan::call($command);
    }
}
