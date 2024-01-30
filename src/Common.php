<?php

use Myth\DB\DB;

if (! defined('db')) {
    /**
     * Returns the database connection object.
     *
     * @param string $connection
     *
     * @return \Myth\DB\Connection
     */
    function db(string $connection = 'default')
    {
        return new DB($connection);
    }
}
