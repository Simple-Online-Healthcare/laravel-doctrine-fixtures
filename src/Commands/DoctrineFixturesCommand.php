<?php

declare(strict_types=1);

namespace SimpleOnlineHealthcare\Doctrine\Commands;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Illuminate\Console\Command;
use SimpleOnlineHealthcare\Doctrine\Fixtures\Loader;

class DoctrineFixturesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doctrine:fixtures:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all Doctrine fixtures';

    public function __construct(
        protected EntityManager $entityManager,
        protected Loader $loader
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->loader->loadFromDirectory(database_path('fixtures'));

        $executor = new ORMExecutor($this->entityManager, new ORMPurger());
        $executor->execute($this->loader->getFixtures());

        $this->output->success('Done');
    }
}
