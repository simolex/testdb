<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191106053045 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('CREATE TABLE NORM_OBJECT (ID NUMBER NOT NULL, CAD_NUM VARCHAR2(100) DEFAULT NULL NULL, REG_ID NUMBER DEFAULT NULL NULL, PRIMARY KEY(ID))');
        $this->addSql('CREATE TABLE NORM_ERR_SLT (ID NUMBER NOT NULL, OBJ_ID NUMBER NOT NULL, BLOCK_ID NUMBER NOT NULL, NORM_VALUES CLOB DEFAULT NULL NULL, PRIMARY KEY(ID))');
        $this->addSql('COMMENT ON COLUMN NORM_ERR_SLT.NORM_VALUES IS \'(DC2Type:json)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('DROP TABLE NORM_OBJECT');
        $this->addSql('DROP TABLE NORM_ERR_SLT');

    }
}
