<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class CreateServiceFile extends Command
{
    // Definisikan signature command dengan argumen 'name'
    protected $signature = 'make:service {name}';

    // Deskripsi command
    protected $description = 'Create a service file with basic CRUD methods';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ambil argumen 'name' dari input user
        $name = $this->argument('name');
        $serviceName = $name . 'Service.php'; // Nama file yang akan dibuat

        // Path tempat file akan disimpan
        $filePath = app_path('Services/' . $serviceName);

        // Buat instance dari Filesystem Laravel untuk manipulasi file
        $filesystem = new Filesystem();

        // Cek jika file sudah ada
        if ($filesystem->exists($filePath)) {
            $this->error("File '{$serviceName}' already exists.");
            return;
        }

        // Template konten dengan 7 method dasar beserta parameter model binding
        $content = "<?php\n\n";
        $content .= "namespace App\Services;\n\n";
        $content .= "use App\Models\\{$name};\n";
        $content .= "use Illuminate\Support\Facades\Validator;\n";
        $content .= "use Illuminate\Http\Request;\n";
        $content .= "use Illuminate\Validation\ValidationException;\n\n";
        $content .= "class {$name}Service\n";
        $content .= "{\n";
        $content .= "    public function index()\n";
        $content .= "    {\n";
        $content .= "        // Logic for listing all {$name}s\n";
        $content .= "        return {$name}::all();\n";
        $content .= "    }\n\n";
        
        $content .= "    public function create()\n";
        $content .= "    {\n";
        $content .= "        // Logic for creating a new {$name}\n";
        $content .= "    }\n\n";
        
        $content .= "    public function store(Request \$request)\n";
        $content .= "    {\n";
        $content .= "        // Validate and store new {$name}\n";
        $content .= "        \$validated = \$this->validateData(\$request);\n";
        $content .= "        return {$name}::create(\$validated);\n";
        $content .= "    }\n\n";
        
        $content .= "    public function show({$name} \${$name})\n";
        $content .= "    {\n";
        $content .= "        // Logic for showing single {$name}\n";
        $content .= "        return \${$name};\n";
        $content .= "    }\n\n";
        
        $content .= "    public function edit({$name} \${$name})\n";
        $content .= "    {\n";
        $content .= "        // Logic for editing {$name}\n";
        $content .= "    }\n\n";
        
        $content .= "    public function update(Request \$request, {$name} \${$name})\n";
        $content .= "    {\n";
        $content .= "        // Validate and update existing {$name}\n";
        $content .= "        \$validated = \$this->validateData(\$request);\n";
        $content .= "        \${$name}->update(\$validated);\n";
        $content .= "        return \${$name};\n";
        $content .= "    }\n\n";
        
        $content .= "    public function destroy({$name} \${$name})\n";
        $content .= "    {\n";
        $content .= "        // Logic for deleting {$name}\n";
        $content .= "        \${$name}->delete();\n";
        $content .= "        return response()->json(['message' => '{$name} deleted successfully']);\n";
        $content .= "    }\n\n";
        
        $content .= "    private function validateData(Request \$request)\n";
        $content .= "    {\n";
        $content .= "        // Validation logic\n";
        $content .= "        return \$request->validate([\n";
        $content .= "            // Add your validation rules here\n";
        $content .= "        ]);\n";
        $content .= "    }\n";
        $content .= "}\n";

        // Membuat direktori 'Services' jika belum ada
        if (!$filesystem->isDirectory(app_path('Services'))) {
            $filesystem->makeDirectory(app_path('Services'), 0755, true);
        }

        // Buat file service dengan konten template
        $filesystem->put($filePath, $content);

        // Beri pesan sukses
        $this->info("Service file '{$serviceName}' created successfully.");
    }
}
