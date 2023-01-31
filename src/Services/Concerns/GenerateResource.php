<?php

namespace TomatoPHP\TomatoApi\Services\Concerns;

use Illuminate\Support\Str;

trait GenerateResource
{
    /**
     * @return void
     */
    private function generateResource(): void
    {
        $resourcePath = $this->module ? module_path($this->module) .'/Http/Resources/Api' : app_path('/Http/Resources/Api');
        $resourceFolder = $this->module ? module_path($this->module) .'/Http/Resources' : app_path('/Http/Resources');

        $this->generateStubs(
            $this->stub .'resource.stub',
            $resourcePath . '/'.$this->model.'Resource.php',
            [
                "path" => $this->module ? 'Modules\\'.$this->module : 'App',
                "model" => $this->model,
                "cols" => $this->generateCols()
            ],
            [
                $resourceFolder,
                $resourcePath
            ]
        );
    }

    /**
     * @return string
     */
    private function generateCols(): string
    {
        $cols = "";
        foreach ($this->getFields() as $key => $item) {
            $cols .= '             "'.$item['name'].'" => $this->'. $item['name'].' ?? null,'."\n";
        }

        return $cols;
    }
}
