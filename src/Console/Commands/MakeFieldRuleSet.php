<?php

namespace Telkins\Validation\Console\Commands;

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

    protected $stub = __DIR__ . '/../../../stubs/DummyFieldRuleSet.stub';
}
