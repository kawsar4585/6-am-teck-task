<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:services {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new services class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = $this->getServicePath($name);

        if (!File::exists(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }

        File::put($path, $this->generateClass($name));

        $this->info("Service class {$name} created successfully!");
    }

    private function getServicePath($name)
    {
        $namespaceParts = explode('/', $name);
        $className = array_pop($namespaceParts);
        $directoryPath = implode('/', $namespaceParts);
        return base_path("app/Services/{$directoryPath}/{$className}.php");
    }

    private function generateClass($name)
    {
        $namespaceParts = explode('/', $name);
        $className = array_pop($namespaceParts);

        if (count($namespaceParts) > 0) {
            $directoryPath = implode('\\', $namespaceParts);
        } else {
            $directoryPath = '';
        }

        if($directoryPath == '') {
            $fullNamespace = 'App\Services';
        } else {
            $fullNamespace = 'App\Services\\' . $directoryPath;
        }
        return "<?php\n\nnamespace $fullNamespace;\n\nclass {$className}\n{\n    // Your code here\n}\n";
    }
}
