<?php

namespace Telkins\Validation\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Telkins\Validation\Providers\RuleSetsServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function setUp()
    {
        parent::setUp();

        // ...
    }

    protected function getPackageProviders($app)
    {
        return [RuleSetsServiceProvider::class];
    }
}