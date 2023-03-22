<?php

namespace Tests;

use BadMethodCallException;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, RefreshDatabase;

    private Generator $faker;

    public function setUp(): void
    {

        parent::setUp();
        Artisan::call('migrate:refresh --seed');
        Artisan::call('passport:install');
    }
}
