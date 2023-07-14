<?php

namespace Tests;

use App\Models\User;
use App\Utils\RolePermissionMapping;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Laravel\Sanctum\Sanctum;
use \Faker\Factory;
use \Faker\Generator;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    //use RefreshDatabaseState;
    use RefreshDatabase;

    protected Generator $faker;

    protected function setUp(): void
    {
        RefreshDatabaseState::$migrated = false;
        parent::setUp();

        Artisan::call('migrate');

        $this->faker = Factory::create();
    }

    /**
     * Sign in the given user or create new one if not provided.
     *
     * @param User|null $user User
     * @param string $as
     * @return User
     */
    protected function signIn(?User $user = null, string $as = 'admin'): User
    {
        $user = $user ?: User::factory()->create();

        Sanctum::actingAs($user, ['*']);

        return $user;
    }
}
