<?php

namespace App\Helper;

trait RenameIndexTrait
{
    /**
     * @var string|null
     */
    private $ownerDatabase;

    /**
     * @required
     */
    private function renameIndexPrimaryKey(?string $tableName, ?string $indexName) : void
    {
        if (!isset($this->ownerDatabase)){
            $this->ownerDatabase = strtoupper($this->connection->getDatabase());
        }
        $result = $this->connection->fetchAssoc(
            'SELECT index_name
                FROM all_ind_columns
                WHERE table_owner = :owner_database
                AND table_name = :name_table
                AND column_name = :name_column', [
                    'owner_database'    => $this->ownerDatabase,
                    'name_table'        => strtoupper($tableName),
                    'name_column'       => 'ID',
                ]/*,
                Connection::PARAM_STR_ARRAY*/
        );
        if (isset($result)) {
            $this->addSql('ALTER INDEX :old_index_name RENAME TO :new_index_name', [
                'old_index_name' => $result['INDEX_NAME'],
                'new_index_name' => $indexName,
            ]);
        }
    }
}
