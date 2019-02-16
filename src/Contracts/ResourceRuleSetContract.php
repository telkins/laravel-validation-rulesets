<?php

namespace Telkins\Validation\Contracts;

interface ResourceRuleSetContract
{
    public function rules() : array;
    public function creationRules() : array;
    public function updateRules() : array;
}
