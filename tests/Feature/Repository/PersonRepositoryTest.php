<?php

namespace Tests\Feature;

use App\Repository\PersonRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class PersonRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();
        $this->personRepository = resolve(PersonRepository::class);
    }

    public function test_repository_creates_person() {
       $person = $this->personRepository->create([
        'firstName' => 'Test',
        'lastName' => 'User',
        'email' => 'testuser@ccrk.app',
        'phoneHome' => '555-555-5555',
        'phoneCell' => '917-555-5555',
       ]);

       $this->assertDatabaseCount('people', 1);
       $this->assertModelExists($person);
    }

    public function test_repository_updates_person() {
       $person = $this->personRepository->create([
        'firstName' => 'Test',
        'lastName' => 'User',
        'email' => 'testuser@ccrk.app',
        'phoneHome' => '555-555-5555',
        'phoneCell' => '917-555-5555',
       ]);

       $this->personRepository->update($person->id, [
        'email' => 'modifieduser@ccrk.app'
       ]);

       $this->assertDatabaseMissing('people', [
        'email' => 'testuser@ccrk.app'
       ]);

       $this->assertDatabaseHas('people', [
        'email' => 'modifieduser@ccrk.app'
       ]);
    }

    public function test_repository_deletes_person() {
       $person = $this->personRepository->create([
        'firstName' => 'Test',
        'lastName' => 'User',
        'email' => 'testuser@ccrk.app',
        'phoneHome' => '555-555-5555',
        'phoneCell' => '917-555-5555',
       ]);

       $this->assertDatabaseCount('people', 1);
       $this->assertModelExists($person);

       $this->personRepository->destroy($person->id);

       $this->assertDatabaseCount('people', 0);
       $this->assertModelMissing($person);
    }
}
