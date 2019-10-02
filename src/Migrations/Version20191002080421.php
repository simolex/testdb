<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191002080421 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');


        $this->addSql('ALTER TABLE NORM_BLOCK ADD (parent_id NUMBER DEFAULT NULL NULL, name VARCHAR2(1000) NOT NULL)');
        $this->addSql('COMMENT ON COLUMN NORM_BLOCK.parent_id IS \'fk_id\'');
        $this->addSql('ALTER TABLE NORM_BLOCK ADD CONSTRAINT FK_1FB86B1C727ACA70 FOREIGN KEY (parent_id) REFERENCES NORM_BLOCK (id)');
        $this->addSql('CREATE INDEX IDX_1FB86B1C727ACA70 ON NORM_BLOCK (parent_id)');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');


        $this->addSql('ALTER TABLE NORM_BLOCK DROP CONSTRAINT FK_1FB86B1C727ACA70');
        $this->addSql('DROP INDEX IDX_1FB86B1C727ACA70');
        $this->addSql('ALTER TABLE NORM_BLOCK DROP (parent_id, name)');

    }
}
