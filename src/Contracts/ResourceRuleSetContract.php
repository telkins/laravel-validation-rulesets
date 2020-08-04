<?php

namespace Telkins\Validation\Contracts;

interface ResourceRuleSetContract
{
    public function rules(?string $key = null) : array;
    public function creationRules(?string $key = null) : array;
    public function updateRules(?string $key = null) : array;
}
