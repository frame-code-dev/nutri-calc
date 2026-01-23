<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\School;
use App\Models\Menu;

class MenuScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_validates_store_request()
    {
        $response = $this->post(route('menu-schedules.store'), []);
        $response->assertSessionHasErrors(['week', 'year', 'school_id', 'assignments']);
    }

    /** @test */
    public function it_shows_success_message_on_valid_store()
    {
        // Create a school and a menu for assignment
        $school = School::factory()->create();
        $menu = Menu::factory()->create(['is_active' => true]);

        $assignments = [];
        // Create assignments for 6 days
        $dates = [];
        $start = now()->setISODate(now()->year, now()->isoWeek)->startOfWeek();
        for ($i = 0; $i < 6; $i++) {
            $date = $start->copy()->addDays($i)->toDateString();
            $dates[] = $date;
            $assignments[] = ['date' => $date, 'menu_id' => $menu->id];
        }

        $payload = [
            'week' => now()->isoWeek,
            'year' => now()->year,
            'school_id' => $school->id,
            'assignments' => $assignments,
        ];

        $response = $this->post(route('menu-schedules.store'), $payload);
        $response->assertSessionHas('success');
        $response->assertRedirect();
    }
}
?>
