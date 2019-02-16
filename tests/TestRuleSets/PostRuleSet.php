<?php

namespace Telkins\Validation\Tests\TestRuleSets;

use Telkins\Validation\AbstractResourceRuleSet;

class PostRuleSet extends AbstractResourceRuleSet
{
    protected function provideRules() : array
    {
        return [
            'subject' => [
                'string',
                'max:255',
            ],
            'body' => [
                'string',
                'max:1024',
            ],
        ];
    }

    protected function provideCreationRules() : array
    {
        return [
            'author_id' => [
                'required',
            ],
            'subject' => [
                'required',
            ],
            // 'body' => [
            // ],
        ];
    }

    protected function provideUpdateRules() : array
    {
        return [
            'reason' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }
}
