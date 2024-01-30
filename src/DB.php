<?php

namespace Myth\DB;

use CodeIgniter\Model;
use Config\Database;

/**
 * Provides the entry point to the database system.
 * Handles loading the database configuration, connecting
 * to the database, and returning the connection object.
 */
class DB
{
    public function __construct(private string $connection = 'default')
    {
        helper('inflector');
    }

    /**
     * Returns
     * @param string $table
     * @return void
     */
    public function map(string $table): Model
    {
        // Try to locate a model for this table
        // by converting the name to PascalCase singular.
        $modelName = singular(pascalize($table)) . 'Model';

        $model = model($modelName, true, $db = Database::connect($this->connection));

        // Load and prepare our default model.
        if ($model === null) {
            $model = model(Mapper::class, true, $db = Database::connect($this->connection));
            $model->setTable($table)
                ->hydrate();
        }

        return $model;
    }
}
