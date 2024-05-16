<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Role;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;


it('can\'t update category', function () {
 
    $user = User::factory()->create();
    $category = Category::factory()->create();
    
    $response = actingAs($user)
        ->put(route('categories.update', $category->first()->id), [
            'name' => 'Category Name',
        ]);

    $response->assertStatus(403);

    // comment vérifier le nom de la category ? 
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

    $category = Category::factory()->create();
    
    $response = actingAs($user)
        ->put(route('categories.update', $category->first()->id), [
            'name' => 'Category Name 2',
            "slug" => "category-name-2",
            "status" => "published"
        ]);
    $response->assertStatus(201);

    assertDatabaseHas('categories', [
        'name' => 'Category Name 2',
    ]);
});
