<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrderController
 */
class OrderControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $orders = Order::factory()->count(3)->create();

        $response = $this->get(route('order.index'));

        $response->assertOk();
        $response->assertViewIs('order.index');
        $response->assertViewHas('orders');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('order.create'));

        $response->assertOk();
        $response->assertViewIs('order.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrderController::class,
            'store',
            \App\Http\Requests\OrderStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $date_order = $this->faker->date();
        $user = User::factory()->create();

        $response = $this->post(route('order.store'), [
            'date_order' => $date_order,
            'user_id' => $user->id,
        ]);

        $orders = Order::query()
            ->where('date_order', $date_order)
            ->where('user_id', $user->id)
            ->get();
        $this->assertCount(1, $orders);
        $order = $orders->first();

        $response->assertRedirect(route('order.index'));
        $response->assertSessionHas('order.id', $order->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $order = Order::factory()->create();

        $response = $this->get(route('order.show', $order));

        $response->assertOk();
        $response->assertViewIs('order.show');
        $response->assertViewHas('order');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $order = Order::factory()->create();

        $response = $this->get(route('order.edit', $order));

        $response->assertOk();
        $response->assertViewIs('order.edit');
        $response->assertViewHas('order');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OrderController::class,
            'update',
            \App\Http\Requests\OrderUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $order = Order::factory()->create();
        $date_order = $this->faker->date();
        $user = User::factory()->create();

        $response = $this->put(route('order.update', $order), [
            'date_order' => $date_order,
            'user_id' => $user->id,
        ]);

        $order->refresh();

        $response->assertRedirect(route('order.index'));
        $response->assertSessionHas('order.id', $order->id);

        $this->assertEquals(Carbon::parse($date_order), $order->date_order);
        $this->assertEquals($user->id, $order->user_id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $order = Order::factory()->create();

        $response = $this->delete(route('order.destroy', $order));

        $response->assertRedirect(route('order.index'));

        $this->assertModelMissing($order);
    }
}
