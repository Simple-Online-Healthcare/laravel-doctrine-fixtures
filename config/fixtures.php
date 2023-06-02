<?php

return [

    /**
     * Which environments should Doctrine Fixtures be autoloaded?
     *
     * Must be provided in a comma separated list.
     */
    'autoloadEnvironments' => implode(',', env('DOCTRINE_FIXTURES_AUTOLOAD_ENVIRONMENTS', 'dev,testing,staging')),

];