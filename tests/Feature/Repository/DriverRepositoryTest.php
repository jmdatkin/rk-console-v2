<?php

namespace Tests\Feature;

use App\Models\Person;
use App\Repository\DriverRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class DriverRepositoryTest extends TestCase
{
   use RefreshDatabase;

   public function setUp(): void
   {
      parent::setUp();
      $this->driverRepository = resolve(DriverRepository::class);
   }

   public function test_repository_creates_driver_and_person()
   {
      $driver = $this->driverRepository->create([
         'firstName' => 'Test',
         'lastName' => 'User',
         'email' => 'testuser@ccrk.app',
         'phoneHome' => '555-555-5555',
         'phoneCell' => '917-555-5555',
      ]);

      $this->assertDatabaseCount('drivers', 1);
      $this->assertDatabaseCount('people', 1);

      $this->assertModelExists($driver);
      $this->assertDatabaseHas('people', [
         'id' => $driver->person_id
      ]);
   }

   public function test_repository_updates_driver_and_person()
   {
      $driver = $this->driverRepository->create([
         'firstName' => 'Test',
         'lastName' => 'User',
         'email' => 'testuser@ccrk.app',
         'phoneHome' => '555-555-5555',
         'phoneCell' => '917-555-5555',
      ]);

      $this->driverRepository->update($driver->id, [
         'email' => 'modifieduser@ccrk.app',
      ]);

      $this->assertDatabaseMissing('people', [
         'email' => 'testuser@ccrk.app'
      ]);
      $this->assertDatabaseHas('people', [
         'email' => 'modifieduser@ccrk.app'
      ]);
   }

   public function test_repository_deletes_driver_and_person()
   {
      $driver = $this->driverRepository->create([
         'firstName' => 'Test',
         'lastName' => 'User',
         'email' => 'testuser@ccrk.app',
         'phoneHome' => '555-555-5555',
         'phoneCell' => '917-555-5555',
      ]);

      $this->driverRepository->destroy($driver->id);

      $this->assertModelMissing($driver);
      $this->assertDatabaseHas('people', [
         'id' => $driver->person_id
      ]);
   }
}
