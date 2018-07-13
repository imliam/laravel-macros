<?php

namespace ImLiam\Macros;

use Illuminate\Support\ServiceProvider;

class MacrosServiceProvider extends ServiceProvider
{
    /**
     * The macro mixin mappings.
     *
     * @var array
     */
    protected $macros = [
        \Illuminate\Support\Collection::class => \ImLiam\Macros\Macros\CollectionMacros::class,
        \Illuminate\Database\Query\Builder::class => \ImLiam\Macros\Macros\QueryBuilderMacros::class,
        \Illuminate\Http\Request::class => \ImLiam\Macros\Macros\RequestMacros::class,
        \Illuminate\Support\Facades\Route::class => \ImLiam\Macros\Macros\RouteFacadeMacros::class,
    ];

    /**
     * Register the macro mixins.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->macros as $class => $mixin) {
            $class::mixin(new $mixin);
        }
    }
}
