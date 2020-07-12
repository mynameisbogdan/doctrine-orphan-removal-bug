<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200712123339 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_3B65BB0C8D9F6D38');
        $this->addSql('DROP INDEX UNIQ_3B65BB0C77153098');
        $this->addSql('CREATE TEMPORARY TABLE __temp__app_order_items AS SELECT id, order_id, code FROM app_order_items');
        $this->addSql('DROP TABLE app_order_items');
        $this->addSql('CREATE TABLE app_order_items (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, order_id INTEGER DEFAULT NULL, code VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_3B65BB0C8D9F6D38 FOREIGN KEY (order_id) REFERENCES app_order (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO app_order_items (id, order_id, code) SELECT id, order_id, code FROM __temp__app_order_items');
        $this->addSql('DROP TABLE __temp__app_order_items');
        $this->addSql('CREATE INDEX IDX_3B65BB0C8D9F6D38 ON app_order_items (order_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_3B65BB0C8D9F6D38');
        $this->addSql('CREATE TEMPORARY TABLE __temp__app_order_items AS SELECT id, order_id, code FROM app_order_items');
        $this->addSql('DROP TABLE app_order_items');
        $this->addSql('CREATE TABLE app_order_items (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, order_id INTEGER DEFAULT NULL, code VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO app_order_items (id, order_id, code) SELECT id, order_id, code FROM __temp__app_order_items');
        $this->addSql('DROP TABLE __temp__app_order_items');
        $this->addSql('CREATE INDEX IDX_3B65BB0C8D9F6D38 ON app_order_items (order_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B65BB0C77153098 ON app_order_items (code)');
    }
}
