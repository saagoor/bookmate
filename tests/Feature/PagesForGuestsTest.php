<?php

namespace Tests\Feature;


it('has welcome page', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

it('has exchanges page', function () {
    $response = $this->get('/exchanges');
    $response->assertStatus(200);
});

it('has challenges page', function () {
    $response = $this->get('/challenges');
    $response->assertStatus(200);
});

it('has books page', function () {
    $response = $this->get('/books');
    $response->assertStatus(200);
});