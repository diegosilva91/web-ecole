<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->enableForeignKeys();
    }

    /**
     * Enables foreign keys.
     *
     * @return void
     */
    public function enableForeignKeys()
    {
        $db = app()->make('db');
        $db->getSchemaBuilder()->enableForeignKeyConstraints();
    }
}
