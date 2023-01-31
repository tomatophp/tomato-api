<?php

namespace TomatoPHP\TomatoApi\Services\Concerns;

trait GenerateValidation
{
    /**
     * @return void
     */
    private function generateValidation(): void
    {
        $requestValidationPath = $this->module ? module_path($this->module) .'/Http/Requests/Api' : app_path('/Http/Requests/Api') ;

        $this->generateStubs(
            $this->stub .'store-validation.stub',
            $requestValidationPath . '/'.'Store'.$this->model.'.php',
            [
                "path" => $this->module ? 'Modules\\'.$this->module : 'App',
                "model" => $this->model,
                "cols" => $this->generateRules()
            ],
            [
                $requestValidationPath
            ]
        );

        $this->generateStubs(
            $this->stub .'update-validation.stub',
            $requestValidationPath . '/'.'Update'.$this->model.'.php',
            [
                "path" => $this->module ? 'Modules\\'.$this->module : 'App',
                "model" => $this->model,
                "cols" => $this->generateRules(true)
            ],
            [
                $requestValidationPath
            ]
        );
    }

    /**
     * @param bool $edit
     * @return string
     */
    private function generateRules(bool $edit = false): string
    {
        $rules = "";
        foreach ($this->getFields() as $key => $item) {
            if ($item['name'] !== 'id') {
                if($key !== 0){
                    $rules .= "            ";
                }
                $rules .= "'{$item['name']}' => ";
                $rules .= "'";
                if($item['required'] === 'required'){
                    if($edit){
                        $rules .= 'sometimes';
                    }
                    else {
                        $rules .= 'required';
                    }

                }
                else {
                    $rules .= 'nullable';
                }

                if($item['maxLength']){
                    $rules .= '|max:'.$item['maxLength'];
                }
                if($item['type'] === 'string' || $item['type'] === 'email' || $item['type'] === 'phone'){
                    $rules .= '|string';
                }
                if($item['type'] === 'email'){
                    $rules .= '|email';
                }
                if($item['type'] === 'tel'){
                    $rules .= '|min:12';
                }
                if($item['type'] === 'password'){
                    $rules .= '|confirmed|min:6';
                }

                $rules .= "'";
                if (($key !== count($this->getFields()) - 1)) {
                    $rules .= ",".PHP_EOL;
                }
            }
        }

        return $rules;
    }
}
