<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Subject;

class SubjectTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * Test creating a record via POST request.
     *
     * @return void
     */
    public function testCreateSubject()
    {
        $data = factory(Subject::class)->make()->toArray();

        $response = $this->post('/subjects', $data);

        $response->assertStatus(201); // Assuming you return 201 on successful creation
    }

    /**
     * Test retrieving a record via GET request.
     *
     * @return void
     */
    public function testRetrieveSubject()
    {
        $subject = factory(Subject::class)->create();

        $response = $this->get('/subjects/' . $subject->id);

        $response->assertStatus(200)
                 ->assertJson($subject->toArray());
    }

    /**
     * Test updating a record via PATCH request.
     *
     * @return void
     */
    public function testUpdateSubject()
    {
        $subject = factory(Subject::class)->create();

        $updatedData = [
            'remarks' => 'PASSED', // Update example
        ];

        $response = $this->patch('/subjects/' . $subject->id, $updatedData);

        $response->assertStatus(200);

        // Optional: Check if the record was actually updated in the database
        $this->assertDatabaseHas('subjects', $updatedData);
    }
}
