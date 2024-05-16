<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Role;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;


it('can\'t delete category', function () {
 
    $user = User::factory()->create();

    $category = Category::factory()->create();
    assertDatabaseCount('categories', 1);
    
    $response = actingAs($user)
        ->delete(route('categories.delete'), [
            'ids' => [$category->id],
        ]);

    assertDatabaseCount('categories', 1);
    $response->assertStatus(403);

});

it('can delete category', function () {
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
    assertDatabaseCount('categories', 1);
    
    $response = actingAs($user)
        ->delete(route('categories.delete'), [
            'ids' => [$category->id],
        ]);

    assertDatabaseCount('categories', 0);
    $response->assertStatus(200);
});


it('can delete many categories', function () {
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

    $categories = Category::factory(3)->create();
    assertDatabaseCount('categories', 3);
    
    $response = actingAs($user)
        ->delete(route('categories.delete'), [
            'ids' => [
                $categories[0]->id,
                $categories[1]->id,
                $categories[2]->id,
            ]
        ]);

    assertDatabaseCount('categories', 0);
    $response->assertStatus(200);
});