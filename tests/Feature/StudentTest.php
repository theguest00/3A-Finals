<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Student;

class StudentClass extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_create_student()
    {
        $studentData = [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'birthdate' => $this->faker->date('Y-m-d'),
            'sex' => $this->faker->randomElement(['MALE', 'FEMALE']),
            'address' => $this->faker->address(),
            'year' => $this->faker->numberBetween(1, 4),
            'course' => $this->faker->randomElement(['BSCS', 'BSIT', 'HRT', 'BSA']),
            'section' => $this->faker->randomElement(['A', 'B', 'C', 'D']),
        ];

        $response = $this->postJson('/students', $studentData);

        $response->assertStatus(201); // Assuming 201 for created
        $response->assertJsonFragment($studentData);

        $this->assertDatabaseHas('students', $studentData);
    }

    public function test_can_get_student()
{
    $student = Student::factory()->create();

    $response = $this->get("/students/{$student->id}");

    $response->assertStatus(200);
    $response->assertJson([
        'id' => $student->id,
        'firstname' => $student->firstname,
        'lastname' => $student->lastname,
        // Include other expected fields here
    ]);
}

public function test_can_update_student()
{
    $student = Student::factory()->create();

    $updateData = [
        'firstname' => 'Updated Firstname',
        // Add other fields you want to update
    ];

    $response = $this->patchJson("/students/{$student->id}", $updateData);

    $response->assertStatus(200);
    $response->assertJsonFragment($updateData);

    $this->assertDatabaseHas('students', $updateData);
}

}
