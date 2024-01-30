<?php

namespace Myth\DB;

use CodeIgniter\Model;

/**
 * An extended Model class that provides
 */
class Mapper extends Model
{
    protected $returnType = 'object';

    /**
     * Holds the table details.
     */
    private array $_structure = [];

    /**
     * The foreign keys for this table.
     */
    private array $_foreignKeys = [];

    /**
     * Ensure any needed helpers are loaded.
     */
    protected function initialize()
    {
        if (! function_exists('singular')) {
            helper('inflector');
        }
    }

    /**
     * Sets the table name for this model.
     */
    public function setTable(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Sets the return type.
     */
    public function returns(string $returnType): self
    {
        $this->returnType = $returnType;

        return $this;
    }

    /**
     * Removes the specified fields from the allowedFields array.
     */
    public function excludeFields(array $fields): self
    {
        $this->allowedFields = array_diff($this->allowedFields, $fields);

        return $this;
    }


    /**
     * Examines the table and stores the structure locally.
     */
    public function hydrate(): self
    {
        // Get the table metadata
        $this->_structure = $this->db->getFieldData($this->table);

        // Find the primary key
        foreach ($this->_structure as $field) {
            if ($field->primary_key) {
                $this->primaryKey = $field->name;
                break;
            }
        }

        // Populate the allowedFields array
        $columnNames = array_column($this->_structure, 'name');
        $this->allowedFields = array_filter(
            $columnNames,
            fn ($field) => $field !== $this->primaryKey &&
                ! in_array($field, ['created_at', 'updated_at', 'deleted_at'])
        );

        // Determine timestamps
        $this->useTimestamps = in_array('created_at', $columnNames) && in_array('updated_at', $columnNames);

        // Determine soft deletes
        $this->useSoftDeletes = in_array('deleted_at', $columnNames);

        // @TODO: Find the foreign keys
        $this->_foreignKeys = $this->db->getForeignKeyData($this->table);

        // Determine the return type
        $this->determineReturnType();

        return $this;
    }

    /**
     * Determines the return type.
     * Default value is 'object'.
     * Will look for an Entity based on the singfular, PascalCase version of the table name.
     */
    private function determineReturnType(): void
    {
        // Do we have an entity for this table?
        $entityName = singular(pascalize($this->table));
        $locator = service('locator');

        $files = $locator->search('Entities/' . $entityName . '.php');
        if (! empty($files)) {
            $this->returnType = $locator->findQualifiedNameFromPath(array_shift($files));
            return;
        }
    }
}
