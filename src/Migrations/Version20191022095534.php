<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191022095534 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');


        $this->addSql('ALTER TABLE NORM_BLOCK ADD (LVL NUMBER DEFAULT NULL NULL)');
        $this->addSql('ALTER TABLE NORM_BLOCK MODIFY (LGT NUMBER NOT NULL, RGT NUMBER NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'oracle', 'Migration can only be executed safely on \'oracle\'.');


        $this->addSql('ALTER TABLE NORM_BLOCK DROP (LVL)');
        $this->addSql('ALTER TABLE NORM_BLOCK MODIFY (LGT NUMBER DEFAULT NULL NULL, RGT NUMBER DEFAULT NULL NULL)');

    }
}
