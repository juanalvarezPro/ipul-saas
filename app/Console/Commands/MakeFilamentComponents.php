<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeFilamentComponents extends Command
{
    protected $signature = 'make:filament-components {model} {panel=app}';
    protected $description = 'Genera componentes y resources de Filament aplicando principios SOLID para el modelo y panel especificado';

    public function handle()
    {
        $model = $this->argument('model');
        $panel = $this->argument('panel'); // Puede ser "app", "admin", "cliente", etc.
        $modelStudly = Str::studly($model);
        // Generamos el plural correctamente, por ejemplo "City" -> "Cities"
        $modelPlural = Str::plural($modelStudly);

        // Ruta base para los componentes
        $basePath = app_path('Filament/Components/' . $modelStudly);
        if (!is_dir($basePath)) {
            mkdir($basePath, 0755, true);
        }

        // Crear archivos de componentes: Form, Search y Table
        $components = [
            'form'   => 'Form',
            'search' => 'Search',
            'table'  => 'Table',
        ];
        foreach ($components as $type => $prefix) {
            $content = $this->getStub($type);
            $content = str_replace(['{model}', '{Model}'], [$model, $modelStudly], $content);
            file_put_contents($basePath . '/' . $prefix . $modelStudly . '.php', $content);
        }

        // Crear archivo Base
        $baseFilePath = app_path('Filament/Base/Base' . $modelStudly . '.php');
        $baseContent = $this->getStub('base');
        $baseContent = str_replace(['{model}', '{Model}'], [$model, $modelStudly], $baseContent);
        file_put_contents($baseFilePath, $baseContent);
        $this->info("Componentes Filament para el modelo {$modelStudly} creados correctamente.");

        // Procesar el argumento panel de forma dinámica
        $panelStudly = Str::studly($panel);
        if ($panel === 'app') {
            $namespace = "App\\Filament";
            $resourceDir = app_path('Filament/Resources');
        } else {
            $namespace = "App\\Filament\\" . $panelStudly;
            $resourceDir = app_path("Filament/{$panelStudly}/Resources");
        }
        if (!is_dir($resourceDir)) {
            mkdir($resourceDir, 0755, true);
        }

        // Cargar stub dinámico y reemplazar valores, incluyendo el plural
        $resourceStub = $this->getStub('resource');
        $resourceStub = str_replace(
            ['{namespace}', '{Model}', '{ModelPlural}'],
            [$namespace, $modelStudly, $modelPlural],
            $resourceStub
        );

        // Guardar el archivo en la carpeta correspondiente
        file_put_contents("{$resourceDir}/{$modelStudly}Resource.php", $resourceStub);
        $this->info("Resource para {$modelStudly} en el panel {$panel} creado correctamente.");
    }

    /**
     * Obtiene el contenido del stub según el tipo.
     */
    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/filament/{$type}.stub"));
    }
}
