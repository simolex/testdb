<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191028091625 extends AbstractMigration
{
    Public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');


        $this->addSql('CREATE SEQUENCE SEQ_MENU_ID START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE SEQUENCE SEQ_MENU_TYPE_ID START WITH 1 MINVALUE 1 INCREMENT BY 1');
        $this->addSql('CREATE TABLE MENU (ID NUMBER(10) NOT NULL, TITLE VARCHAR2(100) NOT NULL, ROUTE VARCHAR2(100) NOT NULL, ALIAS VARCHAR2(255) DEFAULT NULL NULL, STATIC NUMBER(1) NOT NULL, menuTypeId NUMBER(10) DEFAULT NULL NULL, PARENT_ID NUMBER(10) DEFAULT NULL NULL, PRIMARY KEY(ID))');
        $this->addSql('CREATE INDEX IDX_4B90D72787CC5E5D ON MENU (menuTypeId)');
        $this->addSql('CREATE INDEX IDX_4B90D727EF5927F ON MENU (PARENT_ID)');

        //$this->addSql('CREATE UNIQUE INDEX PK_MENU_ID ON MENU (ID)');

        $this->addSql('CREATE TABLE MENU_TYPE (ID NUMBER(10) NOT NULL, TITLE VARCHAR2(100) NOT NULL, PRIMARY KEY(ID))');
        //$this->addSql('CREATE UNIQUE INDEX PK_MTYPE_ID ON MENU_TYPE (ID)');
        $this->addSql('ALTER TABLE MENU ADD CONSTRAINT FK_4B90D72787CC5E5D FOREIGN KEY (menuTypeId) REFERENCES MENU_TYPE (ID)');
        $this->addSql('ALTER TABLE MENU ADD CONSTRAINT FK_4B90D727EF5927F FOREIGN KEY (PARENT_ID) REFERENCES MENU (ID) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');

        $this->addSql('DROP SEQUENCE SEQ_MENU_ID');
        $this->addSql('DROP SEQUENCE SEQ_MENU_TYPE_ID');
        $this->addSql('DROP TABLE MENU');
        $this->addSql('ALTER TABLE MENU DROP CONSTRAINT FK_4B90D727EF5927F');
        $this->addSql('ALTER TABLE MENU DROP CONSTRAINT FK_4B90D72787CC5E5D');
        $this->addSql('DROP TABLE MENU_TYPE');
    }
}
