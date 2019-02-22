<?php

namespace Telkins\Validation\Console\Commands;

use Symfony\Component\Console\Input\InputOption;

class MakeFieldRuleSet extends AbstractMakeRuleSet
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:field-rule-set';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new field rule set class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'FieldRuleSet';

    protected function getOptions()
    {
        return array_merge([
            ['implicit', null, InputOption::VALUE_NONE, 'Have the new class implement Illuminate\Contracts\Validation\ImplicitRule'],
        ], parent::getOptions());
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->hasOption('implicit')) {
            return __DIR__ . '/../../../stubs/DummyImplicitFieldRuleSet.stub';
        }

        return __DIR__ . '/../../../stubs/DummyFieldRuleSet.stub';
    }
}
