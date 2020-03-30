<?php

use Phinx\Migration\AbstractMigration;

class Init extends AbstractMigration
{
    public function change()
    {
        $this->table('posts')
            ->addColumn('date', 'datetime')
            ->addColumn('title', 'string')
            ->addColumn('date', 'datetime')
            ->addColumn('content', 'text')
            ->create();
    }
}