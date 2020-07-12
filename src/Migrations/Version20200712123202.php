<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200712123202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE app_order (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, code VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE app_order_items (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, order_id INTEGER DEFAULT NULL, code VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B65BB0C77153098 ON app_order_items (code)');
        $this->addSql('CREATE INDEX IDX_3B65BB0C8D9F6D38 ON app_order_items (order_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE app_order');
        $this->addSql('DROP TABLE app_order_items');
    }
}
