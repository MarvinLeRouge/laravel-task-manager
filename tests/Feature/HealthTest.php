<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HealthTest extends TestCase
{
    public function test_health_check_returns_200(): void
    {
        $this->get('/up')->assertStatus(200);
    }
}
