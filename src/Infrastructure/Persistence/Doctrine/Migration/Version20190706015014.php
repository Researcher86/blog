<?php

declare(strict_types=1);

namespace Blog\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190706015014 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create post table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('blog_posts');
        $table->addColumn('id', 'string')->setLength(36);
        $table->addColumn('name', 'string');
        $table->addColumn('user_id', 'string');
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('blog_posts');
    }
}
