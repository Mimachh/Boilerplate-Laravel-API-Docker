<?php

declare(strict_types=1);

use App\Models\Role;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;


it('can\'t create category', function () {
 
    $user = User::factory()->create();

    $response = actingAs($user)
        ->post(route('categories.store'), [
            'name' => 'Category Name',
        ]);

    $response->assertStatus(403);

    assertDatabaseCount('categories', 0);
});

it('can create category', function () {
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

    $response = actingAs($user)
        ->post(route('categories.store'), [
            'name' => 'Category Name',
            'slug' => 'category-slug',
            'description' => 'Category Description',
            'status' => 'published'
        ]);

    $response->assertStatus(201);

    assertDatabaseHas('categories', [
        'name' => 'Category Name',
    ]);
    assertDatabaseCount('categories', 1);
});
