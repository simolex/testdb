<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191105113821 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('CREATE SEQUENCE SEQ_USER_ID START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE TABLE USERS (ID NUMBER(10) NOT NULL, EMAIL VARCHAR2(180) NOT NULL, ROLES CLOB NOT NULL, FIRST_NAME VARCHAR2(100) DEFAULT NULL NULL, PRIMARY KEY(ID))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BB063BFD10C6BEC4 ON USERS (EMAIL)');
        //$this->addSql('CREATE UNIQUE INDEX PK_USER_ID ON "USER" (ID)');
        $this->addSql('COMMENT ON COLUMN "USERS".ROLES IS \'(DC2Type:json)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');


        $this->addSql('DROP SEQUENCE SEQ_USER_ID');
        $this->addSql('DROP TABLE USERS');
        //$this->addSql('DROP INDEX PK_MENU_ID');
    }
}
