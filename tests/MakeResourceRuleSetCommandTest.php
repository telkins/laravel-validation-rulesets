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

        $this->assertContains('ResourceRuleSet created successfully.', Artisan::output());

        $shouldOutputFilePath = $this->app['path'] . '/Rules/ResourceRuleSets/PostRuleSet.php';

        $this->assertTrue(File::exists($shouldOutputFilePath), 'File not found in default app/Rules/ResourceRuleSets folder');

        $contents = File::get($shouldOutputFilePath);

        $this->assertContains('namespace App\Rules\ResourceRuleSets;', $contents);

        $this->assertContains('class PostRuleSet extends AbstractResourceRuleSet', $contents);
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

        $this->assertContains('ResourceRuleSet created successfully.', Artisan::output());

        $shouldOutputFilePath = $this->app['path'] . '/MyResourceRuleSets/PostRuleSet.php';

        $this->assertTrue(File::exists($shouldOutputFilePath), 'File not found in custom app/MyResourceRuleSets folder');

        $contents = File::get($shouldOutputFilePath);

        $this->assertContains('namespace App\MyResourceRuleSets;', $contents);

        $this->assertContains('class PostRuleSet extends AbstractResourceRuleSet', $contents);
    }
}
