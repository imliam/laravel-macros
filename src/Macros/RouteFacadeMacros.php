<?php

namespace ImLiam\Macros\Macros;

use Illuminate\Support\Facades\Route;

class RouteFacadeMacros
{
    /**
     * Register a new wildcard route that returns a view if it exists.
     *
     * @param  string  $path
     * @param  string  $viewDirectory
     * @param  array  $data
     * @return \Illuminate\Routing\Route
     */
    public function viewDir() {
        return function($path, $viewDirectory = '', $data = [])
        {
            $path = trim($path, '/') . '/{page?}';

            return $this->get($path, function ($path = '') use ($viewDirectory, $data) {
                $viewPath = "{$viewDirectory}.{$path}";

                if (view()->exists($viewPath)) {
                    return view($viewPath)->with($data);
                }

                if (view()->exists($viewPath . '.index')) {
                    return view($viewPath . '.index')->with($data);
                }

                abort(404);

            })->where('page', '.*');
        };
    }
}
