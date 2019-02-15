<?php

namespace Telkins\Validation\Tests;

use Illuminate\Support\Facades\Validator;
use Telkins\Validation\Tests\TestRuleSets\NewEmailRuleSet;
use Telkins\Validation\Tests\TestRuleSets\NewConfirmedEmailRuleSet;

class FieldRuleSetTest extends TestCase
{
    protected function getError($key, $attribute, $extra = []) : string
    {
        return __($key, array_merge(['attribute' => str_replace('_', ' ', $attribute)], $extra));
    }

    /**
     * @test
     */
    public function it_will_return_true_for_valid_values()
    {
        $this->assertTrue((new NewEmailRuleSet())->passes('attribute', 'me@mydomain.com'));
    }

    /**
     * @test
     */
    public function it_will_return_false_for_invalid_values()
    {
        $this->assertFalse((new NewEmailRuleSet())->passes('attribute', 'not.an.email'));
    }

    /**
     * @test
     * @dataProvider providesInvalidValues
     */
    public function it_returns_the_expected_validation_message($value, $errorKey, $extra = [])
    {
        $attribute = 'email_address';

        $rule = new NewEmailRuleSet();

        $rule->passes($attribute, $value);

        $this->assertEquals($this->getError($errorKey, $attribute, $extra), $rule->message());
    }

    public function providesInvalidValues()
    {
        return [
            [
                null,
                'validation.required',
            ],
            [
                'not.an.email',
                'validation.email',
            ],
            [
                'this.email.address.is.a.bit.too.long@mydomain.com',
                'validation.max.string',
                ['max' => 25],
            ],
        ];
    }

    /**
     * @test
     */
    public function it_plays_nice_with_confirmed_and_request_data()
    {
        $requestData = [
            'email_address' => 'me@mydomain.com',
            'email_address_confirmation' => 'me@mydomain.com',
        ];

        $this->assertTrue((new NewConfirmedEmailRuleSet($requestData))->passes('email_address', 'me@mydomain.com'));
    }

    /**
     * @test
     */
    public function it_plays_nice_with_separate_confirmed_and_no_request_data()
    {
        $requestData = [
            'email_address' => 'me@mydomain.com',
            'email_address_confirmation' => 'me@mydomain.com',
        ];

        $validator = Validator::make($requestData, [
            'email_address' => [
                new NewEmailRuleSet(),
                'confirmed',
            ],
        ]);

        $this->assertTrue($validator->passes());
    }

    /**
     * @test
     */
    public function it_returns_the_expected_validation_message_when_cannot_confirm_with_confirmed_and_request_data()
    {
        $attribute = 'email_address';

        $requestData = [
            $attribute => 'me@mydomain.com',
            // NO CONFIRMATION...!
        ];

        $rule = new NewConfirmedEmailRuleSet($requestData);

        $this->assertFalse($rule->passes($attribute, 'me@mydomain.com'));
        $this->assertEquals($this->getError('validation.confirmed', $attribute), $rule->message());
    }

    /**
     * @test
     */
    public function it_returns_the_expected_validation_message_when_cannot_confirm_with_separate_confirmed_and_no_request_data()
    {
        $attribute = 'email_address';

        $validator = Validator::make(
            [
                $attribute => 'me@mydomain.com',
                // NO CONFIRMATION...!
            ], [
                $attribute => [
                    new NewEmailRuleSet(),
                    'confirmed',
                ],
            ]
        );

        $this->assertFalse($validator->passes());
        $this->assertEquals($this->getError('validation.confirmed', $attribute), $validator->errors()->first());
    }
}
