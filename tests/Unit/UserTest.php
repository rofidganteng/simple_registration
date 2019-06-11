<?php

namespace Tests\Unit;


use Tests\TestCase;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{

    use DatabaseTransactions;

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

    public function testRegisterDuplicateEmail()
    {
        // Given
        $existingUser = factory(\App\User::class)->create();

        // When
        $newUser = factory(\App\User::class)->make();
        $newUser->email = $existingUser->email;
        $response = $this->json('POST', 'users', $newUser->toArray());

        // Then
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => false
            ])
            ->assertJsonStructure([
                'errors' => ['email'],
            ]);

        $this->assertDatabaseMissing('users', [
            'email' => $newUser->email,
            'first_name'=> $newUser->first_name,
            'last_name' => $newUser->last_name,
            'mobile'=> $newUser->mobile,
        ]);
    }

    public function testRegisterDuplicateMobile()
    {
        // Given
        $existingUser = factory(\App\User::class)->create();

        // When
        $newUser = factory(\App\User::class)->make();
        $newUser->mobile = $existingUser->mobile;
        $response = $this->json('POST', 'users', $newUser->toArray());

        // Then
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => false
            ])
            ->assertJsonStructure([
                'errors' => ['mobile'],
            ]);

        $this->assertDatabaseMissing('users', [
            'email' => $newUser->email,
            'first_name'=> $newUser->first_name,
            'last_name' => $newUser->last_name,
            'mobile'=> $newUser->mobile,
        ]);
    }

    public function testRegisterWrongMobileFormat()
    {
        // Given

        // When
        $newUser = factory(\App\User::class)->make();

        // too much digit (>14)
        $newUser->mobile = '08983778988879';
        $response = $this->json('POST', 'users', $newUser->toArray());
        // Then
        $response->assertStatus(200)->assertJson(['success' => false])->assertJsonStructure(['errors' => ['mobile']]);
        $this->assertDatabaseMissing('users', [
            'email' => $newUser->email,
            'first_name'=> $newUser->first_name,
            'last_name' => $newUser->last_name,
            'mobile'=> $newUser->mobile,
        ]);

        // Non Indonesia Mobile Number
        $newUser->mobile = '+6389654323240';
        $response = $this->json('POST', 'users', $newUser->toArray());
        // Then
        $response->assertStatus(200)->assertJson(['success' => false])->assertJsonStructure(['errors' => ['mobile']]);
        $this->assertDatabaseMissing('users', [
            'email' => $newUser->email,
            'first_name'=> $newUser->first_name,
            'last_name' => $newUser->last_name,
            'mobile'=> $newUser->mobile,
        ]);
    }
}
