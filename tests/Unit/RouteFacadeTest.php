<?php

namespace ImLiam\Macros\Tests\Unit;

use ImLiam\Macros\Tests\TestCase;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

class RouteFacadeTest extends TestCase
{
    /** @test */
    public function a_view_directory_can_be_defined()
    {
        Route::viewDir('route', '/', ['foo' => 'bar']);

        View::addLocation(__DIR__ . '/Fixtures');

        $this->assertContains('Index bar', $this->get('/route')->getContent());
        $this->assertContains('Test bar', $this->get('/route/view')->getContent());
        $this->assertContains('Sub-index bar', $this->get('/route/sub')->getContent());
        $this->assertContains('Sub-test bar', $this->get('/route/sub/test')->getContent());
        $this->assertEquals(404, $this->get('/a/route/sub/nonexistent')->getStatusCode());
    }

}
