<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191003114157 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        //$this->addSql('CREATE SEQUENCE SEQ_NORM_BLOCK_ID START WITH 1 MINVALUE 1 INCREMENT BY 1');
        //$this->addSql('CREATE SEQUENCE SEQ_NORM_PROCESS_ID START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('ALTER TABLE NORM_BLOCK ADD (code VARCHAR2(3) NOT NULL)');
        $this->addSql('COMMENT ON COLUMN NORM_BLOCK.parent_id IS \'id\'');
        $this->addSql('CREATE UNIQUE INDEX PK_NORM_BLOCK_ID ON NORM_BLOCK (ID)');
        $this->addSql('CREATE UNIQUE INDEX PK_NORM_PROCESS_ID ON NORM_PROCESS (ID)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        //$this->addSql('DROP SEQUENCE SEQ_NORM_BLOCK_ID');
        //$this->addSql('DROP SEQUENCE SEQ_NORM_PROCESS_ID');
        $this->addSql('DROP INDEX PK_NORM_BLOCK_ID');
        $this->addSql('ALTER TABLE NORM_BLOCK DROP (code)');
        $this->addSql('COMMENT ON COLUMN NORM_BLOCK.PARENT_ID IS \'fk_id\'');
        $this->addSql('DROP INDEX PK_NORM_PROCESS_ID');
    }
}
