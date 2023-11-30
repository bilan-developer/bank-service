<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->getRouteParameters()->each(function ($params) {
                $this->mapRoutes($params);
            });
        });
    }

    /**
     * @param array $params
     *
     * @return void
     */
    private function mapRoutes(array $params): void
    {
        collect(File::files(base_path('routes/' . $params['dir'])))
            ->each(function ($file) use ($params) {
                Route::prefix($params['prefix'])
                    ->middleware($params['middleware'])
                    ->namespace($this->namespace)
                    ->group($file);
            });
    }

    /**
     * @return Collection
     */
    private function getRouteParameters(): Collection
    {
        return collect([
            'api' => [
                'middleware' => [
                    'api',
                ],
                'prefix' => 'api',
                'dir' => 'api',
            ],
            'web' => [
                'middleware' => 'web',
                'prefix' => '',
                'dir' => 'web',
            ],
        ]);
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)
                ->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
