<?php

namespace Myth\DB;

use CodeIgniter\Model;

interface MapperInterface
{
    /**
     * Returns a model for the given table name.
     *
     * If the system can find a model based on the singular,
     * PascalCase version of the table name, it will return that.
     * Otherwise it will return a Mapper instance.
     *
     * @param string $table
     * @return ModelInterface
     */
    public function map(string $table): Model;
}
