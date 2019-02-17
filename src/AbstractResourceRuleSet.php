<?php

namespace Telkins\Validation;

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

    protected function provideRules() : array
    {
        return [];
    }

    protected function provideCreationRules() : array
    {
        return [];
    }

    protected function provideUpdateRules() : array
    {
        return [];
    }
}
