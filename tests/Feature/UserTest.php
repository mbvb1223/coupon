<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateANewUser()
    {
        $response = $this->post('/api/users/create', ['name' => 'Khien', 'email' => rand(1, 10000) . "_test@khien.com", 'password' => 123456])
            ->assertJson([
                'success' => true,
                'code' => 201,
                'message' => 'Created successfully!',
                'data' => [
                    'name' => 'Khien',
                ]
            ])->assertJsonStructure([
                'success',
                'code',
                'message',
                'data' => ['id', 'name', 'email']
            ]);

        $response->assertStatus(200);
    }

    public function testCreateAnExistingUser()
    {
        $this->post('/api/users/create', ['name' => 'Khien', 'email' =>  "test@khien.com", 'password' => 123456])
            ->assertJson(['success' => true]);

        $response = $this->post('/api/users/create', ['name' => 'Khien', 'email' =>  "test@khien.com", 'password' => 123456])
            ->assertJson([
                'success' => false,
                'code' => 409,
                'message' => 'User email already exists',
                'data' => [
                ]
            ]);

        $response->assertStatus(200);
    }

    public function testCreateNotToken()
    {
        $this->post('/api/users/create', ['name' => 'Khien', 'email' =>  "test@khien.com", 'password' => 123456])
            ->assertJson(['success' => true]);

        $response = $this->post('/api/users/token', ['email' =>  "test@khien.com", 'password' => 12333456, 'device_name' => 'aaa'])
            ->assertJson([
                'success' => false,
                'message' => 'The provided credentials are incorrect.',
            ]);

        $response->assertStatus(200);
    }

    public function testCreateTokenSuccesfully()
    {
        $this->post('/api/users/create', ['name' => 'Khien', 'email' =>  "test@khien.com", 'password' => 123456])
            ->assertJson(['success' => true]);

        $response = $this->post('/api/users/token', ['email' =>  "test@khien.com", 'password' => 123456, 'device_name' => 'aaa'])
            ->assertJson([
                'success' => true,
                'code' => 201,
                'message' => 'Created successfully!',
            ]);

        $response->assertStatus(200);
    }
}
