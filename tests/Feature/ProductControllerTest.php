<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_index()
    {
        $product = Product::factory()->count(50)->create();

        $response = $this->json('GET', '/api/products');

        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json')
            ->assertJsonCount(500);
    }

    public function test_create_new_product()
    {
        $data = [
            'name' => 'Hola',
            'price' => 1000,
        ];
        $response = $this->json('POST', '/api/products', $data);

        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json');

        $this->assertDatabaseHas('products', $data);
    }

    public function test_update_product()
    {
        /** @var Product $product */
        $product = Product::factory()->create();

        $data = [
            'name' => 'Update Product',
            'price' => 20000,
        ];

        $response = $this->json('PATCH', "/api/products/{$product->getKey()}", $data);

        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json');
    }

    public function test_show_product()
    {
        /** @var Product $product */
        $product = Product::factory()->create();;

        $response = $this->json('GET', "/api/products/{$product->getKey()}");

        $response
            ->assertSuccessful()
            ->assertHeader('content-type', 'application/json');
    }

//     public function test_delete_product()
//     {
//         /** @var Product $product */
//         $product = Product::factory()->create();

//         $response = $this->deleteJson("/api/products/{$product->getKey()}");

//         $response
//             ->assertSuccessful()
//             ->assertHeader('content-type', 'application/json');

//         $this->assertDeleted($product);
//     }
}
