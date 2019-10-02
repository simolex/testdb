<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191002051448 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('CREATE SEQUENCE SEQ_NORM_BLOCK_ID START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE SEQUENCE SEQ_NORM_PROCESS_ID START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE TABLE NORM_BLOCK (ID NUMBER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX pk_block_id ON NORM_BLOCK (ID)');
        $this->addSql('COMMENT ON COLUMN NORM_BLOCK.ID IS \'id\'');
        $this->addSql('CREATE TABLE NORM_PROCESS (ID NUMBER NOT NULL, PARENT_ID NUMBER DEFAULT NULL NULL, ID_NORM_BLOCK NUMBER DEFAULT NULL NULL, NOTE VARCHAR2(1000) DEFAULT NULL NULL)');
        $this->addSql('CREATE INDEX i_norm_process_parent_id ON NORM_PROCESS (PARENT_ID)');
        $this->addSql('CREATE INDEX i_norm_process_block_id ON NORM_PROCESS (ID_NORM_BLOCK)');
        $this->addSql('CREATE UNIQUE INDEX pk_process_id ON NORM_PROCESS (ID)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('DROP SEQUENCE SEQ_NORM_BLOCK_ID');
        $this->addSql('DROP SEQUENCE SEQ_NORM_PROCESS_ID');
        $this->addSql('DROP TABLE NORM_BLOCK');
        $this->addSql('DROP TABLE NORM_PROCESS');
    }
}
