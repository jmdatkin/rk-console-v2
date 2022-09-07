<?php

namespace Tests\Feature;

use App\Models\Recipient;
use App\Models\Route;
use App\Services\AssignmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssignmentServiceTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->assignmentService = resolve(AssignmentService::class);
    }

    public function test_can_assign_recipient_to_route()
    {
        $recipient = Recipient::factory()->create();
        $route = Route::factory()->create();

        $this->assertDatabaseCount('recipient_route', 0);

        $this->assignmentService->assign_recipient(
            $route->id,
            $recipient->id,
            0);
        
        $this->assertDatabaseCount('recipient_route', 1);
        $this->assertDatabaseHas('recipient_route', [
            'recipient_id' => $recipient->id,
            'route_id' => $route->id,
            'weekday' => 0
        ]);
    }

    public function test_can_deassign_recipient_from_route()
    {
        $recipient = Recipient::factory()->create();
        $route = Route::factory()->create();

        $this->assignmentService->assign_recipient(
            $route->id,
            $recipient->id,
            0);
        
        $this->assertDatabaseCount('recipient_route', 1);
        $this->assertDatabaseHas('recipient_route', [
            'recipient_id' => $recipient->id,
            'route_id' => $route->id,
            'weekday' => 0
        ]);

        $this->assignmentService->deassign_recipient(
            $route->id,
            $recipient->id,
            0);

        $this->assertDatabaseCount('recipient_route', 0);
        $this->assertDatabaseMissing('recipient_route', [
            'recipient_id' => $recipient->id,
            'route_id' => $route->id,
            'weekday' => 0
        ]);
    }

    public function test_recipient_assigned_only_one_route_per_day()
    {
    }

    public function test_can_assign_driver_to_route()
    {
    }

    public function test_can_deassign_driver_from_route()
    {
    }

    public function test_driver_assigned_multiple_routes_per_day()
    {
    }
}
