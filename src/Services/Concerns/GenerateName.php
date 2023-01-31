<?php

namespace TomatoPHP\TomatoApi\Services\Concerns;

use Illuminate\Support\Str;

trait GenerateName
{
    /**
     * @param bool|null $sp
     * @param bool|null $sg
     * @param bool|null $hasSpace
     * @return string
     */
    private function generateName(
        bool|null $sp = false,
        bool|null $sg = false,
        bool|null $hasSpace = true
    ): string
    {
        $expload = explode('_', $this->table);
        $tableName = "";
        $x = 1;
        foreach ($expload as $item) {
            if ($sp) {
                if ($sg) {
                    if ($x === count($expload)) {
                        $item = Str::singular(Str::ucfirst($item));
                        $tableName .= $item;
                    } else {
                        if ($hasSpace) {
                            $item = Str::ucfirst($item) . " Generator.php";
                        } else {
                            $item = Str::ucfirst($item);
                        }

                        $tableName .= $item;
                    }
                    $x++;
                } else {
                    if ($hasSpace) {
                        $item = Str::ucfirst($item) . " Generator.php";
                    } else {
                        $item = Str::ucfirst($item);
                    }

                    $tableName .= $item;
                }
            } else {
                $item = Str::ucfirst($item);
                $tableName .= $item;
            }
        }

        return Str::ucfirst($tableName);
    }
}
