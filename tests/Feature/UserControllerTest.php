<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testThatCanFetchUserDetails()
    {
        $user = User::factory()->create();

        $this->get('/api/v1/users/' . $user->id)
            ->assertStatus(200)
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

    public function testThatCanUpdateUserDetails()
    {
        $user = User::factory()->create();
        $payLoad = [
            'first_name' => "Deo",
            'last_name' => "Peter",
            'phone_number' => "08123076309",
            'address' => "hello address goes here"
        ];
        $this->patch('/api/v1/users/' . $user->id, $payLoad)
            ->assertStatus(200)
            ->assertJson([
                'data' => $payLoad
            ]);
    }


    public function testThatDeleteUserDetail()
    {
        $user = User::factory()->create();
        $this->delete('/api/v1/users/' . $user->id)
            ->assertStatus(204);
    }
}