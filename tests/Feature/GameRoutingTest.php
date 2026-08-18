<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Route;

class GameRoutingTest extends TestCase
{
    public function test_root_serves_the_game_export(): void
    {
        $this->get('/')->assertOk()->assertHeader('Content-Type', 'text/html; charset=UTF-8');
    }

    public function test_dashboard_is_available_at_dashboard(): void
    {
        $this->assertTrue(Route::has('admin.dashboard'));
        $this->assertSame('dashboard', Route::getRoutes()->getByName('admin.dashboard')->uri());
    }

    public function test_game_assets_are_served_without_exposing_files_outside_games(): void
    {
        $this->get('/games/style.css')->assertOk();
        $this->get('/games/../.env')->assertNotFound();
    }
}
