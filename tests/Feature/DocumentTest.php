<?php

use App\Models\User;

test('documents screen can be rendered ', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $response = $this->get('/documents');
    $response
        ->assertOk()
        ->assertSee('Documents');
});
