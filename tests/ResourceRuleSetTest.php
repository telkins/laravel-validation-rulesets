<?php

namespace Telkins\Validation\Tests;

use Illuminate\Support\Facades\Validator;
use Telkins\Validation\Tests\TestRuleSets\PostRuleSet;

class ResourceRuleSetTest extends TestCase
{
    protected function getError($key, $attribute, $extra = []) : string
    {
        return __($key, array_merge(['attribute' => str_replace('_', ' ', $attribute)], $extra));
    }

    /**
     * @test
     */
    public function it_returns_the_expected_rules()
    {
        $rules = (new PostRuleSet())->rules();

        $this->assertIsArray($rules);
        $this->assertEquals($rules, [
            'subject' => [
                'string',
                'max:255',
            ],
            'body' => [
                'string',
                'max:1024',
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_returns_the_expected_creation_rules()
    {
        $rules = (new PostRuleSet())->creationRules();

        $this->assertIsArray($rules);
        $this->assertEquals($rules, [
            'author_id' => [
                'required',
            ],
            'subject' => [
                'string',
                'max:255',
                'required',
            ],
            'body' => [
                'string',
                'max:1024',
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_returns_the_expected_update_rules()
    {
        $rules = (new PostRuleSet())->updateRules();

        $this->assertIsArray($rules);
        $this->assertEquals($rules, [
            'subject' => [
                'string',
                'max:255',
            ],
            'body' => [
                'string',
                'max:1024',
            ],
            'reason' => [
                'required',
                'string',
                'max:255',
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_validates_valid_creation_data()
    {
        $requestData = [
            'author_id' => 1234,
            'subject' => 'My First Post',
            'body' => 'This is my first post.',
        ];

        $validator = Validator::make($requestData, (new PostRuleSet())->creationRules());

        $this->assertTrue($validator->passes());
    }

    /**
     * @test
     * @dataProvider providesInvalidCreationData
     */
    public function it_invalidates_invalid_creation_data($requestData, $errorKey, $errorAttribute, $extra = [])
    {
        $validator = Validator::make($requestData, (new PostRuleSet())->creationRules());

        $this->assertFalse($validator->passes());
        $this->assertEquals($this->getError($errorKey, $errorAttribute, $extra), $validator->errors()->first());
    }

    public function providesInvalidCreationData()
    {
        return [
            [
                [
                    // 'author_id' => 1234,
                    'subject' => 'My First Post',
                    'body' => 'This is my first post.',
                ],
                'validation.required',
                'author_id',
            ],
            [
                [
                    'author_id' => 1234,
                    // 'subject' => 'My First Post',
                    'body' => 'This is my first post.',
                ],
                'validation.required',
                'subject',
            ],
            [
                [
                    'author_id' => 1234,
                    'subject' => str_repeat('x', 256),
                    'body' => 'This is my first post.',
                ],
                'validation.max.string',
                'subject',
                ['max' => 255],
            ],
            [
                [
                    'author_id' => 1234,
                    'subject' => 'My First Post',
                    'body' => str_repeat('x', 1025),
                ],
                'validation.max.string',
                'body',
                ['max' => 1024],
            ],
        ];
    }

    /**
     * @test
     */
    public function it_validates_valid_update_data()
    {
        $requestData = [
            'subject' => 'My Corrected Subject',
            'reason' => 'The subject was incorrect.',
        ];

        $validator = Validator::make($requestData, (new PostRuleSet())->updateRules());

        $this->assertTrue($validator->passes());
    }

    /**
     * @test
     * @dataProvider providesInvalidUpdateData
     */
    public function it_invalidates_invalid_update_data($requestData, $errorKey, $errorAttribute, $extra = [])
    {
        $validator = Validator::make($requestData, (new PostRuleSet())->updateRules());

        $this->assertFalse($validator->passes());
        $this->assertEquals($this->getError($errorKey, $errorAttribute, $extra), $validator->errors()->first());
    }

    public function providesInvalidUpdateData()
    {
        return [
            [
                [
                    'subject' => str_repeat('x', 256),
                    'reason' => 'I wanted to make a very long subject.',
                ],
                'validation.max.string',
                'subject',
                ['max' => 255],
            ],
            [
                [
                    'body' => str_repeat('x', 1025),
                    'reason' => 'I wanted to make a very long post.',
                ],
                'validation.max.string',
                'body',
                ['max' => 1024],
            ],
            [
                [
                    'subject' => 'My Corrected Subject',
                    'body' => 'My corrected post.',
                    // 'reason' => 'This is my first post.',
                ],
                'validation.required',
                'reason',
            ],
            [
                [
                    'reason' => str_repeat('x', 256),
                ],
                'validation.max.string',
                'reason',
                ['max' => 255],
            ],
        ];
    }
}
