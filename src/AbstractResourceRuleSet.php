<?php

namespace Telkins\Validation;

use Illuminate\Support\Str;
use Telkins\Validation\Contracts\ResourceRuleSetContract;

abstract class AbstractResourceRuleSet implements ResourceRuleSetContract
{
    public function rules() : array
    {
        return $this->provideRules();
    }

    public function creationRules() : array
    {
        return array_merge_recursive(
            $this->provideRules(),
            $this->provideCreationRules()
        );
    }

    public function updateRules() : array
    {
        return array_merge_recursive(
            $this->provideRules(),
            $this->provideUpdateRules()
        );
    }

    abstract protected function provideRules() : array;

    abstract protected function provideCreationRules() : array;

    abstract protected function provideUpdateRules() : array;
}
