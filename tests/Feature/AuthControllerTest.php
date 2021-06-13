<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function testRequiresEmailAndLogin()
    {
        $response = $this->post('/api/v1/login');
        $response->assertStatus(422)
            ->assertJsonFragment([
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.'],
            ]);
    }

    public function testUserLoginsWithCorrectCredentials()
    {

        $user = User::factory()->create([
            'password' => bcrypt($password = 'hello-patricia'),
        ]);

        $response = $this->post('/api/v1/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200);
    }

    public function testsRequiresInputValidation()
    {
        $this->post('/api/v1/register')
            ->assertStatus(422)
            ->assertJsonFragment([
                'first_name' => ['The first name field is required.'],
                'last_name' => ['The last name field is required.'],
                'email' => ['The email field is required.'],
                'phone_number' => ['The phone number field is required.'],
                'password' => ['The password field is required.'],
            ]);
    }

    public function testsRequirePasswordConfirmation()
    {
        $payload = [
            'first_name' => 'John',
            'last_name' => "Jay",
            'email' => 'john@toptal.com',
            'phone_number' => '08134283622',
            'password' => 'hello#$@1234',
        ];

        $this->post('/api/v1/register', $payload)
            ->assertStatus(422)
            ->assertJsonFragment([
                'password' => ['The password confirmation does not match.'],
            ]);
    }

    public function testsUserRegistrationCreatedSuccessfully()
    {
        $payload = [
            'first_name' => 'John',
            'last_name' => "Jay",
            'email' => 'johnjay@gmail.com',
            'phone_number' => '08134283622',
            'address' => "abcdef",
            'password' => 'test@4#123',
            'password_confirmation' => 'test@4#123',
        ];

        $this->json('post', '/api/v1/register', $payload)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'phone_number',
                    'address',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }
}