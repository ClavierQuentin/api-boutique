<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ItemController
 */
class ItemControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $items = Item::factory()->count(3)->create();

        $response = $this->get(route('item.index'));

        $response->assertOk();
        $response->assertViewIs('item.index');
        $response->assertViewHas('items');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('item.create'));

        $response->assertOk();
        $response->assertViewIs('item.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ItemController::class,
            'store',
            \App\Http\Requests\ItemStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $title = $this->faker->sentence(4);
        $price = $this->faker->randomFloat(/** decimal_attributes **/);
        $image_url = $this->faker->text;

        $response = $this->post(route('item.store'), [
            'title' => $title,
            'price' => $price,
            'image_url' => $image_url,
        ]);

        $items = Item::query()
            ->where('title', $title)
            ->where('price', $price)
            ->where('image_url', $image_url)
            ->get();
        $this->assertCount(1, $items);
        $item = $items->first();

        $response->assertRedirect(route('item.index'));
        $response->assertSessionHas('item.id', $item->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $item = Item::factory()->create();

        $response = $this->get(route('item.show', $item));

        $response->assertOk();
        $response->assertViewIs('item.show');
        $response->assertViewHas('item');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $item = Item::factory()->create();

        $response = $this->get(route('item.edit', $item));

        $response->assertOk();
        $response->assertViewIs('item.edit');
        $response->assertViewHas('item');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ItemController::class,
            'update',
            \App\Http\Requests\ItemUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $item = Item::factory()->create();
        $title = $this->faker->sentence(4);
        $price = $this->faker->randomFloat(/** decimal_attributes **/);
        $image_url = $this->faker->text;

        $response = $this->put(route('item.update', $item), [
            'title' => $title,
            'price' => $price,
            'image_url' => $image_url,
        ]);

        $item->refresh();

        $response->assertRedirect(route('item.index'));
        $response->assertSessionHas('item.id', $item->id);

        $this->assertEquals($title, $item->title);
        $this->assertEquals($price, $item->price);
        $this->assertEquals($image_url, $item->image_url);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $item = Item::factory()->create();

        $response = $this->delete(route('item.destroy', $item));

        $response->assertRedirect(route('item.index'));

        $this->assertModelMissing($item);
    }
}
