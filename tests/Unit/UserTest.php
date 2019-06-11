<?php

namespace Tests\Unit;

use Tests\TestCase;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testRegister()
    {
        // Given

        // When
        $faker = Factory::create();
        $response = $this->json('POST', 'users', [
            'first_name' => $first_name = $faker->name,
            'last_name' => $last_name = $faker->name,
            'email' => $email = $faker->unique()->safeEmail,
            'mobile' => $mobile = '089097'.mt_rand(000000, 999999),
        ]);

        // Then
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);

        $this->assertDatabaseHas('users', [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'mobile' => $mobile,
        ]);
    }
}
