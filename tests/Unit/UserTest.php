<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
    * A user creation test.
    *
    * @return void
    */
    public function test_create_user()
    {
        $this->withoutExceptionHandling();
        $this->seed('Database\\Seeders\\DatabaseSeederDev');
        $userAuth = User::factory()->create();
        $userAuth->assignRole('admin');
        $this->actingAs($userAuth);

        $response = $this->post('admin/users/create', [
            'email'=>'test@test.com',
            'first_name'=>'Test',
            'last_name'=>'User',
            "roles" => [0 => "superadmin"]

        ]);

        $response->assertStatus(302);
        $response->assertRedirect();

    }

    /**
     * A user modification test.
     *
     * @return void
     */
    public function test_edit_user()
    {
        $this->withoutExceptionHandling();
        $this->seed('Database\\Seeders\\DatabaseSeederDev');
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);
        $this->post(\route('user.edit',['user'=>$user->id]),[
            'email'=>'test@test.com',
            'first_name'=>'Test',
            'last_name'=>'User',
            "roles" => [0 => "superadmin"]
        ])
            ->assertStatus(302);

    }

    /**
     * Users display test
     *
     * @return void
     */
    public function test_users_routes()
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();
        $userAuth = User::factory()->create();
        $this->actingAs($userAuth);

        $response = $this->get('http://127.0.0.1:8000/users');
        $response->assertStatus(200);
    }

    /**
     * Test the route to create a user
     *
     * @return void
     */
    public function test_create_users_routes()
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();
        $userAuth = User::factory()->create();
        $this->actingAs($userAuth);

        $response = $this->get('http://127.0.0.1:8000/users/create');
        $response->assertStatus(200);
    }

    /**
     * Test the route to modify a user
     *
     * @return void
     */
    public function test_edit_users_routes()
    {
        $this->withoutExceptionHandling();
        $this->seed('Database\\Seeders\\DatabaseSeederDev');
        $user = User::factory()->create();
        $user->assignRole('admin');
        $this->actingAs($user);
        $this->get(\route('user.edit',['user'=>$user->id]))
            ->assertSuccessful()
            ->assertStatus(200);

    }




}
