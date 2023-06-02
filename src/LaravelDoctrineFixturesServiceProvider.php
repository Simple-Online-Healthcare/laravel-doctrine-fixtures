<?php

namespace SimpleOnlineHealthcare\Doctrine;

use Illuminate\Support\ServiceProvider;
use SimpleOnlineHealthcare\Doctrine\Fixtures\Loader;

class LaravelDoctrineFixturesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerFixtureLoader();
    }

    protected function registerFixtureLoader(): void
    {
        if (($environments = config('fixtures.autoloadEnvironments')) && !empty($environments)) {
            return;
        }

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