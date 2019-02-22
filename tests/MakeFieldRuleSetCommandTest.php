<?php

namespace Telkins\Validation\Tests;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class MakeFieldRuleSetCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_create_a_field_rule_set()
    {
        $exitCode = Artisan::call('make:field-rule-set', [
            'name' => 'EmailRuleSet',
            '--force' => true,
        ]);

        $this->assertEquals(0, $exitCode);

        $this->assertContains('FieldRuleSet created successfully.', Artisan::output());

        $shouldOutputFilePath = $this->app['path'] . '/Rules/FieldRuleSets/EmailRuleSet.php';

        $this->assertTrue(File::exists($shouldOutputFilePath), 'File not found in default app/Rules/FieldRuleSets folder');

        $contents = File::get($shouldOutputFilePath);

        $this->assertContains('namespace App\Rules\FieldRuleSets;', $contents);

        $this->assertContains('class EmailRuleSet extends AbstractFieldRuleSet', $contents);
    }

    /**
     * @test
     */
    public function it_can_create_an_implicit_field_rule_set()
    {
        $exitCode = Artisan::call('make:field-rule-set', [
            'name' => 'EmailRuleSet',
            '--implicit' => true,
            '--force' => true,
        ]);

        $this->assertEquals(0, $exitCode);

        $this->assertContains('FieldRuleSet created successfully.', Artisan::output());

        $shouldOutputFilePath = $this->app['path'] . '/Rules/FieldRuleSets/EmailRuleSet.php';

        $this->assertTrue(File::exists($shouldOutputFilePath), 'File not found in default app/Rules/FieldRuleSets folder');

        $contents = File::get($shouldOutputFilePath);

        $this->assertContains('namespace App\Rules\FieldRuleSets;', $contents);

        $this->assertContains('use Illuminate\Contracts\Validation\ImplicitRule;', $contents);

        $this->assertContains('class EmailRuleSet extends AbstractFieldRuleSet implements ImplicitRule', $contents);
    }

    /**
     * @test
     */
    public function it_can_create_a_field_rule_set_with_a_custom_namespace()
    {
        $exitCode = Artisan::call('make:field-rule-set', [
            'name' => 'MyFieldRuleSets/EmailRuleSet',
            '--force' => true,
        ]);

        $this->assertEquals(0, $exitCode);

        $this->assertContains('FieldRuleSet created successfully.', Artisan::output());

        $shouldOutputFilePath = $this->app['path'] . '/MyFieldRuleSets/EmailRuleSet.php';

        $this->assertTrue(File::exists($shouldOutputFilePath), 'File not found in custom app/MyFieldRuleSets folder');

        $contents = File::get($shouldOutputFilePath);

        $this->assertContains('namespace App\MyFieldRuleSets;', $contents);

        $this->assertContains('class EmailRuleSet extends AbstractFieldRuleSet', $contents);
    }
}
