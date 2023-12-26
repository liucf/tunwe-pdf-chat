<?php

use App\Models\User;

test('user can upload document', function () {
    // $user = User::factory()->create();

    // $this->actingAs($user);

    $response = $this->get('storedocs');

    $response
        ->assertOk();
});
