<?php

namespace Migrations;

declare(strict_types=1);

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use  Doctrine\DBAL\Connection;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191002051448 extends AbstractMigration
{
    private $ownerDatabase;

    public function __construct()
    {
        $this->ownerDatabase = strtoupper($this->connection->getDatabase());
    }

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
        $this->addSql('CREATE TABLE NORM_BLOCK (ID NUMBER NOT NULL, PRIMARY KEY(id))');

        $this->addSql('COMMENT ON COLUMN NORM_BLOCK.ID IS \'id\'');
        $this->addSql('CREATE TABLE NORM_PROCESS (ID NUMBER NOT NULL, PARENT_ID NUMBER DEFAULT NULL NULL, ID_NORM_BLOCK NUMBER DEFAULT NULL NULL, NOTE VARCHAR2(1000) DEFAULT NULL NULL, PRIMARY KEY(id))');

        $this->addSql('CREATE INDEX i_norm_process_parent_id ON NORM_PROCESS (PARENT_ID)');
        $this->addSql('CREATE INDEX i_norm_process_block_id ON NORM_PROCESS (ID_NORM_BLOCK)');
        //$this->addSql('CREATE UNIQUE INDEX pk_process_id ON NORM_PROCESS (ID)');
        //
        if($indexName = $this->getNameIndexPrimaryKey('NORM_BLOCK') !== false){
            $this->addSql('ALTER INDEX ' . $indexName . ' RENAME TO PK_BLOCK_ID');

        }

        if($indexName = $this->getNameIndexPrimaryKey('NORM_PROCESS') !== false){
            $this->addSql('ALTER INDEX ' . $indexName . ' RENAME TO PK_PROCESS_ID');

        }
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

    private function getNameIndexPrimaryKey(?string $tableName)
    {
        $result = $this->connection->fetchAssoc(
            'SELECT index_name
                FROM all_ind_columns
                WHERE table_owner = :owner_database
                AND table_name = :name_table
                AND column_name = :name_column', [
                    'owner_database'    => $ownerDatabase,
                    'name_table'        => strtoupper($tableName),
                    'name_column'       => 'ID',
                ],
                Connection::PARAM_STR_ARRAY
        );
        if (!isset($result)) return false;
        return $result['INDEX_NAME'];

    }
}
