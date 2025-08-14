<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceBookingApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_service()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        Sanctum::actingAs($admin);

        $response = $this->postJson('/api/services', [
            'name' => 'Test Service',
            'description' => 'Service Description',
            'price' => 500,
            'status' => 'active'
        ]);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Service created']);
        $this->assertDatabaseHas('services', ['name' => 'Test Service']);
    }

    /** @test */
    public function customer_can_book_service()
    {
        $customer = User::factory()->create(['is_admin' => false]);
        $service = Service::factory()->create(['status' => 'active']);
        Sanctum::actingAs($customer);

        $response = $this->postJson('/api/bookings', [
            'service_id' => $service->id,
            'booking_date' => now()->addDays(2)->toDateString(),
        ]);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Service booked successfully']);
        $this->assertDatabaseHas('bookings', ['service_id' => $service->id, 'user_id' => $customer->id]);
    }

    /** @test */
    public function customer_cannot_book_service_on_past_date()
    {
        $customer = User::factory()->create(['is_admin' => false]);
        $service = Service::factory()->create(['status' => 'active']);
        Sanctum::actingAs($customer);

        $response = $this->postJson('/api/bookings', [
            'service_id' => $service->id,
            'booking_date' => now()->subDays(1)->toDateString(),
        ]);

        $response->assertStatus(422); // Validation error
    }
}
