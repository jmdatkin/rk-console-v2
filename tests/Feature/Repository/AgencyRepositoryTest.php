<?php

namespace Tests\Feature;

use App\Repository\AgencyRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class AgencyRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->agencyRepository = resolve(AgencyRepository::class);
    }

    public function test_repository_creates_agency() {
       $agency = $this->agencyRepository->create([
         'name' => 'Test Agency',
         'notes' => 'Test'
       ]);

       $this->assertDatabaseCount('agencies', 1);
       $this->assertModelExists($agency);
    }

    public function test_repository_updates_agency() {
       $agency = $this->agencyRepository->create([
         'name' => 'Test Agency',
         'notes' => 'Test'
       ]);

       $this->agencyRepository->update($agency->id, [
        'name' => 'Cosmic Test Agency',
        'notes' => 'Flawless'
       ]);

       $this->assertDatabaseMissing('agencies', [
         'name' => 'Test Agency',
         'notes' => 'Test'
       ]);

       $this->assertDatabaseHas('agencies', [
        'name' => 'Cosmic Test Agency',
        'notes' => 'Flawless'
       ]);
    }

    public function test_repository_deletes_agency() {
       $agency = $this->agencyRepository->create([
         'name' => 'Test Agency',
         'notes' => 'Test'
       ]);

       $this->assertDatabaseCount('agencies', 1);
       $this->assertModelExists($agency);

       $this->agencyRepository->destroy($agency->id);

       $this->assertDatabaseCount('agencies', 0);
       $this->assertModelMissing($agency);
    }
}
