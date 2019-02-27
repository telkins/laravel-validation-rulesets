<?php

namespace Telkins\Validation\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Telkins\Validation\Providers\RuleSetsServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // ...
    }

    protected function getPackageProviders($app)
    {
        return [RuleSetsServiceProvider::class];
    }
}