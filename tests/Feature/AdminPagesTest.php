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

it('has writers page', function () {
    $response = $this->get('/admin/writers');
    $response->assertStatus(200);
    $response->assertSee('Writers');
});

it('has publishers page', function () {
    $response = $this->get('/admin/publishers');
    $response->assertStatus(200);
    $response->assertSee('Publishers');
});

it('has exchanges page', function () {
    $response = $this->get('/admin/exchanges');
    $response->assertStatus(200);
    $response->assertSee('Exchanges');
});

it('has challenges page', function () {
    $response = $this->get('/admin/challenges');
    $response->assertStatus(200);
    $response->assertSee('Challenges');
});

it('has users page', function () {
    $response = $this->get('/admin/users');
    $response->assertStatus(200);
    $response->assertSee('Users');
});
