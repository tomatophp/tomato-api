<?php

namespace TomatoPHP\TomatoApi\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use TomatoPHP\TomatoApi\Services\ApiGenerator;
use TomatoPHP\ConsoleHelpers\Traits\RunCommand;

class CreateApiCrudCommand extends Command
{
    use RunCommand;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'tomato:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Full Api Crud To Modules/Controllers ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $check = true;
        while ($check){
            $table = $this->ask('🍅 Please input your table name you went to create CRUD? (ex: users)');

            if(\Illuminate\Support\Facades\Schema::hasTable($table)){
                $check = false;
            }
            else {
                $this->error("Sorry table not found!");
            }
        }

        //Check if user need to use HMVC
        $isModule=$this->ask('🍅 Do you went to use HMVC module? (y/n)', 'y');
        if(!$isModule){
            $isModule = 'y';
        }
        $module= false;
        if($isModule === 'y'){
            $module=$this->ask('🍅 Please input your module name? (ex: Translations)');
            if($module){
                if(class_exists(\Nwidart\Modules\Facades\Module::class)){
                    $check = \Nwidart\Modules\Facades\Module::find($module);
                    $this->info("🍅 Module not found but we will create it for you ");
                    if(!$check){
                        $this->artisanCommand(["module:make", $module]);
                    }
                }
                else {
                    $this->error("🍅 Sorry nwidart/laravel-modules not installed please install it first");
                }
            }
        }

        try {
            $newGenerator = new ApiGenerator($table, $module);
            $newGenerator->generate();

            $this->line('<fg=green>🍅 Api Created Sueccssfuly :)</>');
            $this->line('<fg=green>🍅 Please Go To Your Module And Register InterFace And Repository In App Providers AppServiceProvider register() function </>');
            $this->line('<fg=green>🍅 Example</>');
            $this->line('
            <fg=white>
$this->app->bind(
    '.Str::ucfirst(Str::camel(Str::singular($table))).'RepositoryInterface::class,
    '.Str::ucfirst(Str::camel(Str::singular($table))).'Repository::class
);
            </>');
            $this->line('<fg=green>🍅 API Resource CRUD Has been generated successfully</>');

        } catch (\Exception $e) {
            $this->error($e);
        }

        return Command::SUCCESS;

    }

}
