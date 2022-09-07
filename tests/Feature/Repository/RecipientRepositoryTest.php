<?php

namespace Tests\Feature;

use App\Models\Person;
use App\Repository\RecipientRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class RecipientRepositoryTest extends TestCase
{
   use RefreshDatabase;

   public function setUp(): void
   {
      parent::setUp();
      $this->recipientRepository = resolve(RecipientRepository::class);
   }

   public function test_repository_creates_recipient_and_person()
   {
      $recipient = $this->recipientRepository->create([
         'firstName' => 'Test',
         'lastName' => 'User',
         'email' => 'testuser@ccrk.app',
         'phoneHome' => '555-555-5555',
         'phoneCell' => '917-555-5555',
         'numMeals' => 33,
         'address' => '123 Test Blvd.'
      ]);

      $this->assertDatabaseCount('recipients', 1);
      $this->assertDatabaseCount('people', 1);

      $this->assertModelExists($recipient);
      $this->assertDatabaseHas('people', [
         'id' => $recipient->person_id
      ]);
   }

   public function test_repository_updates_recipient_and_person()
   {
      $recipient = $this->recipientRepository->create([
         'firstName' => 'Test',
         'lastName' => 'User',
         'email' => 'testuser@ccrk.app',
         'phoneHome' => '555-555-5555',
         'phoneCell' => '917-555-5555',
         'numMeals' => 33,
         'address' => '123 Test Blvd.'
      ]);

      $this->recipientRepository->update($recipient->id, [
         'email' => 'modifieduser@ccrk.app',
         'numMeals' => 22,
         'address' => '567 Cosmic Test Rd.'
      ]);

      $this->assertDatabaseMissing('recipients', [
         'numMeals' => 33,
         'address' => '123 Test Blvd.'
      ]);
      $this->assertDatabaseHas('recipients', [
         'numMeals' => 22,
         'address' => '567 Cosmic Test Rd.'
      ]);

      $this->assertDatabaseMissing('people', [
         'email' => 'testuser@ccrk.app'
      ]);
      $this->assertDatabaseHas('people', [
         'email' => 'modifieduser@ccrk.app'
      ]);
   }

   public function test_repository_deletes_recipient_and_person()
   {
      $recipient = $this->recipientRepository->create([
         'firstName' => 'Test',
         'lastName' => 'User',
         'email' => 'testuser@ccrk.app',
         'phoneHome' => '555-555-5555',
         'phoneCell' => '917-555-5555',
         'numMeals' => 33,
         'address' => '123 Test Blvd.'
      ]);

      $this->recipientRepository->destroy($recipient->id);

      $this->assertModelMissing($recipient);
      $this->assertDatabaseHas('people', [
         'id' => $recipient->person_id
      ]);
   }
}
