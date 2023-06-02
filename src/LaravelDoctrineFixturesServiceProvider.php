<?php

namespace SimpleOnlineHealthcare\Doctrine;

use Illuminate\Support\ServiceProvider;
use SimpleOnlineHealthcare\Doctrine\Commands\DoctrineFixturesCommand;
use SimpleOnlineHealthcare\Doctrine\Fixtures\Loader;

class LaravelDoctrineFixturesServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/fixtures.php' => config_path('fixtures.php'),
        ], 'config');

        $this->commands([DoctrineFixturesCommand::class]);
    }

    public function register()
    {
        $this->registerFixtureLoader();
    }

    protected function registerFixtureLoader(): void
    {
        if (($environments = config('fixtures.autoloadEnvironments')) && !empty($environments)) {
            return;
        }

        $environments = explode(',', $environments);

        if (!in_array(env('APP_ENV'), $environments)) {
            return;
        }

        $this->app->bind(Loader::class, function () {
            $loader = new Loader();

            $loader->setInstantiator(function ($fixtureClass) {
                return $this->app->make($fixtureClass);
            });

            return $loader;
        });
    }
}