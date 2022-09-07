<?php

namespace Tests\Feature;

use App\Repository\RouteRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class RouteRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->routeRepository = resolve(RouteRepository::class);
    }

    public function test_repository_creates_route() {
       $route = $this->routeRepository->create([
         'name' => 'Test Route',
         'notes' => 'Test'
       ]);

       $this->assertDatabaseCount('routes', 1);
       $this->assertModelExists($route);
    }

    public function test_repository_updates_route() {
       $route = $this->routeRepository->create([
         'name' => 'Test Route',
         'notes' => 'Test'
       ]);

       $this->routeRepository->update($route->id, [
        'name' => 'Cosmic Test Route',
        'notes' => 'Flawless'
       ]);

       $this->assertDatabaseMissing('routes', [
         'name' => 'Test Route',
         'notes' => 'Test'
       ]);

       $this->assertDatabaseHas('routes', [
        'name' => 'Cosmic Test Route',
        'notes' => 'Flawless'
       ]);
    }

    public function test_repository_deletes_route() {
       $route = $this->routeRepository->create([
         'name' => 'Test Route',
         'notes' => 'Test'
       ]);

       $this->assertDatabaseCount('routes', 1);
       $this->assertModelExists($route);

       $this->routeRepository->destroy($route->id);

       $this->assertDatabaseCount('routes', 0);
       $this->assertModelMissing($route);
    }
}
