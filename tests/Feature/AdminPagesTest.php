<?php

use App\Models\User;


beforeEach(function () {
    $admin = User::factory()->create(['admin' => true]);
    $this->actingAs($admin);
});


it('has dashboard page', function () {
    $response = $this->get('/admin');
    $response->assertStatus(200);
});

it('has books page', function () {
    $response = $this->get('/admin/books');
    $response->assertStatus(200);
    $response->assertSee('Books');
});
