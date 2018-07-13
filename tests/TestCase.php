<?php

namespace ImLiam\Macros\Tests;

use ImLiam\Macros\MacrosServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * add the package provider
     *
     * @param $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [MacrosServiceProvider::class];
    }
}
