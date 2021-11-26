<?php

namespace Tests\Feature;

use App\Enumerations\Exceptions;
use App\Enumerations\Messages;
use App\Models\Sale;
use App\Models\Seller;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class SaleFeatureTest extends TestCase
{
    use DatabaseMigrations;

    public function test_should_return_all_sales(): void
    {
        $sale = Sale::factory()->count(5)->create();

        $this->get('api/sale')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                'current_page' => 1,
                'total' => $sale->count(),
                'per_page' => 15,
            ]);
    }

    public function test_should_create_sale_response_http_code_201(): void
    {
        $description = 'Description-Test';

        $payload = [
            'seller_id' => Seller::factory()->create()->id,
            'description' => $description,
            'value' => 2500.50,
        ];

        $this->post('api/sale', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'description',
                'value',
                'commission',
                'seller_id',
                'seller',
            ]);

        $this->assertDatabaseCount('sales', 1);
        $this->assertDatabaseHas('sales', ['description' => $description, ]);
    }

    public function test_should_create_sale_without_correct_payload_response_http_code_422(): void
    {
        $this->post('api/sale', [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonFragment(['message' => 'The seller id field is required.']);

        $this->assertDatabaseCount('sales', 0);
    }

    public function test_should_show_sale_by_id_and_response_http_code_200(): void
    {
        $sale = Sale::factory()->create();

        $this->get('api/sale/' . $sale->id)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                [
                    'id',
                    'description',
                    'value',
                    'commission',
                    'seller_id',
                    'seller',
                ],
            ]);
    }

    public function test_should_show_sale_by_id_and_response_http_code_404_not_found(): void
    {
        $this->get('api/sale/' . 0)
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonFragment([
                'shortMessage' => Exceptions::NOT_FOUND,
                'message' => Lang::get('exceptions.' . Exceptions::NOT_FOUND),
                'httpCode' => Response::HTTP_NOT_FOUND,
            ]);
    }

    public function test_should_response_http_code_200_when_edit_sale(): void
    {
        $sale = Sale::factory()->create();

        $this->get('api/sale/' . $sale->id . '/edit')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'description',
                'value',
                'commission',
                'seller_id',
            ]);
    }

    public function test_should_response_http_code_200_when_update_sale(): void
    {
        $description = 'Update_Description-Test';

        $payload = [
            'seller_id' => Seller::factory()->create()->id,
            'description' => $description,
            'value' => 2500.50,
        ];

        $sale = Sale::factory()->create();

        $this->put('api/sale/' . $sale->id, $payload)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment(['message' => Lang::get('messages.' . Messages::SALE_UPDATED)]);

        $this->assertDatabaseHas('sales', [
            'description' => $description,
        ]);
    }

    public function test_should_response_http_code_200_when_delete_sale(): void
    {
        $sale = Sale::factory()->create();

        $this->delete('api/sale/' . $sale->id)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment(['message' => Lang::get('messages.' . Messages::SALE_DELETED)]);

        $this->assertSoftDeleted($sale);
    }
}
