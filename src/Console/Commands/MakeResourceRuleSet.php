<?php

namespace Telkins\Validation\Console\Commands;

class MakeResourceRuleSet extends AbstractMakeRuleSet
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:resource-rule-set';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new resource rule set class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'ResourceRuleSet';

    protected $stub = __DIR__ . '/../../../stubs/DummyResourceRuleSet.stub';
}
