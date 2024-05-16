<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Role;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;


it('can\'t see category', function () {
 
    $user = User::factory()->create();

    $category = Category::factory()->create();
    $response = actingAs($user)
        ->get(route('categories.show', $category->first()->id));

    
    $response->assertStatus(403);

  
});

it('can see category', function () {
    $roles = Role::factory()->count(3)->sequence(
        [
            'name' => 'Super Admin',
            'slug' => 'super_admin',
        ],
        [
            'name' => 'Admin',
            'slug' => 'admin',
        ],
        [
            'name' => 'Customer',
            'slug' => 'customer',
        ],
        [
            'name' => 'User',
            'slug' => 'user',
        ],
    )->create();

    $user = User::factory()->create();

    $adminRole = Role::where('slug', 'super_admin')->first();

    if ($adminRole) {
        $user->roles()->attach($adminRole->id);
    }

    $category = Category::factory()->create();
    $response = actingAs($user)
        ->get(route('categories.show', $category->first()->id));

    $response->assertStatus(200);

});
