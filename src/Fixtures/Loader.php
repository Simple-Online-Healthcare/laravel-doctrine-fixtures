<?php

declare(strict_types=1);

namespace SimpleOnlineHealthcare\Doctrine\Fixtures;

use Closure;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader as BaseLoader;
use RuntimeException;

use function call_user_func;
use function is_callable;

class Loader extends BaseLoader
{
    protected ?Closure $instantiator;

    public function setInstantiator(?Closure $instantiator): self
    {
        $this->instantiator = $instantiator;

        return $this;
    }

    public function getInstantiator(): ?Closure
    {
        return $this->instantiator;
    }

    protected function createFixture($class): FixtureInterface
    {
        if (isset($this->instantiator) && is_callable($this->instantiator)) {
            return call_user_func($this->instantiator, $class);
        }

        $instance = new $class();

        if (!$instance instanceof FixtureInterface) {
            throw new RuntimeException("$class is not an instance of Doctrine\Common\DataFixtures\FixtureInterface.");
        }

        return $instance;
    }
}
