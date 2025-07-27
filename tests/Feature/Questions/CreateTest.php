<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Laravel\Sanctum\Sanctum;

use function Pest\Laravel\assertDatabaseHas;

it('can create a question', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    \Pest\Laravel\postJson(route('questions.store'), [
        'question' => 'test question',
    ])->assertSuccessful();

    assertDatabaseHas('questions', [
        'user_id'  => $user->id,
        'question' => 'test question',
    ]);
});

it('after creating a new question, i need make sure that it creates on _draft_ status', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    \Pest\Laravel\postJson(route('questions.store'), [
        'question' => 'test question',
    ])->assertSuccessful();

    assertDatabaseHas('questions', [
        'user_id'  => $user->id,
        'status'   => 'draft',
        'question' => 'test question',
    ]);
});
