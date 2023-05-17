<?php
namespace App\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

abstract class KodingCommand extends Command{
    protected function replace($name,$type){
        return str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
                '{{modelNamePluralUpperCase}}',
                '{{modelNameSingularUpperCase}}',
            ],
            [
                Str::studly($name),
                strtolower(Str::pluralStudly($name)),
                strtolower(Str::studly($name)),
                ucfirst(Str::pluralStudly($name)),
                ucfirst(Str::studly($name))
            ],
            $this->getStub($type)
        );
    }

    protected function getStub($type)
    {
        return file_get_contents(__DIR__ . ("/stub/$type.stub"));
    }
}