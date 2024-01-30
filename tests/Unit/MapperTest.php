<?php

use Tests\TestCase;
use Myth\DB\Mapper;
use Tests\Support\Entities\Car;

class MapperTest extends TestCase
{
    public function testHydrate()
    {
        $mapper = new Mapper();

        $mapper->setTable('users')
            ->hydrate();

        $this->assertEquals('users', $mapper->table);
        $this->assertEquals('object', $mapper->returnType);
        $this->assertEquals('id', $mapper->primaryKey);
        $this->assertTrue($mapper->useTimestamps);
        $this->assertTrue($mapper->useSoftDeletes);
        $this->assertEquals(
            array_values(['username', 'status', 'status_message', 'active', 'last_active']),
            array_values($mapper->allowedFields)
        );
        $this->assertEquals('object', $mapper->returnType);
    }

    public function testReturns()
    {
        $mapper = new Mapper();

        $mapper->setTable('users')
            ->returns('array')
            ->hydrate();

        $this->assertEquals('array', $mapper->returnType);
    }

    public function testExcludeFields()
    {
        $mapper = new Mapper();

        $mapper->setTable('users')
            ->hydrate()
            ->excludeFields(['status', 'status_message', 'active', 'last_active']);

        $this->assertEquals(
            array_values(['username']),
            array_values($mapper->allowedFields)
        );
    }

    public function testFindsEntityForReturnType()
    {
        $mapper = new Mapper();

        $mapper->setTable('cars')
            ->hydrate();

        $this->assertEquals('\\'. Car::class, $mapper->returnType);
    }
}
