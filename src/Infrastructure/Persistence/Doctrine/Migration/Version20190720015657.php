<?php

declare(strict_types=1);

namespace Blog\Infrastructure\Persistence\Doctrine\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190720015657 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create comment table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('blog_comments');
        $table->addColumn('id', 'guid');
        $table->addColumn('text', 'string');
        $table->addColumn('user_id', 'guid');
        $table->addColumn('post_id', 'guid');
        $table->setPrimaryKey(['id', 'user_id', 'post_id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('blog_comments');
    }
}
