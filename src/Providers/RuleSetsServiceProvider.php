<?php

namespace Telkins\Validation\Providers;

use Illuminate\Support\ServiceProvider;
use Telkins\Validation\Console\Commands\MakeFieldRuleSet;

class RuleSetsServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeFieldRuleSet::class,
            ]);
        }
    }
}
