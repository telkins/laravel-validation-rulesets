<?php

namespace Telkins\Validation\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

abstract class AbstractMakeRuleSet extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description;

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type;

    protected $stub;

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        if ($this->isCustomNamespace()) {
            return $rootNamespace;
        }

        return "$rootNamespace\\Rules\\{$this->type}s";
    }

    protected function getOptions()
    {
        return [
            ['force', null, InputOption::VALUE_NONE, 'Create the class even if the rule set already exists'],
        ];
    }

    protected function isCustomNamespace(): bool
    {
        return Str::contains($this->argument('name'), '/');
    }
}
