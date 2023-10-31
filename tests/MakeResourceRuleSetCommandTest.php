<?php

namespace Telkins\Validation\Tests;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class MakeResourceRuleSetCommandTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_create_a_resource_rule_set()
    {
        $exitCode = Artisan::call('make:resource-rule-set', [
            'name' => 'PostRuleSet',
            '--force' => true,
        ]);

        $this->assertEquals(0, $exitCode);

        $output = Artisan::output();
        $this->assertStringContainsString('ResourceRuleSet', $output);
        $this->assertStringContainsString('created successfully.', $output);

        $shouldOutputFilePath = $this->app['path'] . '/Rules/ResourceRuleSets/PostRuleSet.php';

        $this->assertTrue(File::exists($shouldOutputFilePath), 'File not found in default app/Rules/ResourceRuleSets folder');

        $contents = File::get($shouldOutputFilePath);

        $this->assertStringContainsString('namespace App\Rules\ResourceRuleSets;', $contents);

        $this->assertStringContainsString('class PostRuleSet extends AbstractResourceRuleSet', $contents);
    }

    /**
     * @test
     */
    public function it_can_create_a_resource_rule_set_with_a_custom_namespace()
    {
        $exitCode = Artisan::call('make:resource-rule-set', [
            'name' => 'MyResourceRuleSets/PostRuleSet',
            '--force' => true,
        ]);

        $this->assertEquals(0, $exitCode);

        $output = Artisan::output();
        $this->assertStringContainsString('ResourceRuleSet', $output);
        $this->assertStringContainsString('created successfully.', $output);

        $shouldOutputFilePath = $this->app['path'] . '/MyResourceRuleSets/PostRuleSet.php';

        $this->assertTrue(File::exists($shouldOutputFilePath), 'File not found in custom app/MyResourceRuleSets folder');

        $contents = File::get($shouldOutputFilePath);

        $this->assertStringContainsString('namespace App\MyResourceRuleSets;', $contents);

        $this->assertStringContainsString('class PostRuleSet extends AbstractResourceRuleSet', $contents);
    }
}
