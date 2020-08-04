<?php

namespace Telkins\Validation;

use OutOfBoundsException;
use Telkins\Validation\Contracts\ResourceRuleSetContract;

abstract class AbstractResourceRuleSet implements ResourceRuleSetContract
{
    public function rules(?string $key = null) : array
    {
        return $this->getRules($this->provideRules(), $key);
    }

    public function creationRules(?string $key = null) : array
    {
        return $this->getRules(array_merge_recursive(
            $this->provideCreationRules(),
            $this->provideRules(),
        ), $key);
    }

    public function updateRules(?string $key = null) : array
    {
        return $this->getRules(array_merge_recursive(
            $this->provideUpdateRules(),
            $this->provideRules(),
        ), $key);
    }

    protected function getRules(array $rules, ?string $key) : array
    {
        if (null === $key) {
            return $rules;
        }

        return $this->getRulesForKey($rules, $key);
    }

    protected function getRulesForKey(array $rules, string $key) : array
    {
        $this->guardAgainstInvalidKey($key, $rules);

        return $rules[$key];
    }

    protected function guardAgainstInvalidKey(string $key, array $rules)
    {
        if (! array_key_exists($key, $rules)) {
            throw new OutOfBoundsException("invalid key, '{$key}'");
        }
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
