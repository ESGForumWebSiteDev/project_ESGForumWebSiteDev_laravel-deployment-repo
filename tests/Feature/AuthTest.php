<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
  use RefreshDatabase;

  public function test_user_can_register()
  {
    $response = $this->postJson('/api/register', [
      'userId' => 'testuser',
      'password' => 'securepassword',
      'name' => 'Test User',
      'affiliation' => 'Test University',
    ]);

    $response->assertStatus(201);
    $response->assertJson(['message' => 'Registration successful! You can now log in.']);
    $this->assertDatabaseHas('users', ['userId' => 'testuser']);
  }

  public function test_user_can_login()
  {
    $user = User::create([
      'userId' => 'testuser',
      'password' => Hash::make('securepassword'),
      'name' => 'Test User',
      'affiliation' => 'Test University',
    ]);

    $response = $this->postJson('/api/login', [
      'userId' => 'testuser',
      'password' => 'securepassword',
    ]);

    $response->assertStatus(200);
    $response->assertJson(['message' => 'Login successful!']);
  }
}