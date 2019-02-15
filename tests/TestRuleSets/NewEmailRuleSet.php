<?php

namespace Telkins\Validation\Tests\TestRuleSets;

use Telkins\Validation\AbstractFieldRuleSet;

class NewEmailRuleSet extends AbstractFieldRuleSet
{
    public function rules() : array
    {
        return [
            'required',
            'email',
            'max:25',
        ];
    }
}
