<?php

namespace Telkins\Validation;

use OutOfBoundsException;
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
            $this->provideCreationRules(),
            $this->provideRules()
        );
    }

    public function updateRules() : array
    {
        return array_merge_recursive(
            $this->provideUpdateRules(),
            $this->provideRules()
        );
    }

    public function fieldRules(string $field) : array
    {
        return $this->getFieldRules($field, $this->rules());
    }

    public function fieldCreationRules(string $field) : array
    {
        return $this->getFieldRules($field, $this->creationRules());
    }

    public function fieldUpdateRules(string $field) : array
    {
        return $this->getFieldRules($field, $this->updateRules());
    }

    protected function getFieldRules(string $field, array $rules) : array
    {
        $this->guardAgainstInvalidField($field, $rules);

        return $rules[$field];
    }

    protected function guardAgainstInvalidField(string $field, array $rules)
    {
        if (! array_key_exists($field, $rules)) {
            throw new OutOfBoundsException("invalid field, '{$field}'");
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
