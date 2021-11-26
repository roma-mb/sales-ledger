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

class SellerFeatureTest extends TestCase
{
    use DatabaseMigrations;

    public function test_should_return_all_sellers(): void
    {
        $sale   = Sale::factory()->has(Seller::factory())->create();
        $seller = $sale->seller;

        $this->get('api/seller')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment([
                [
                    'id' => $seller->id,
                    'name' => $seller->name,
                    'email' => $seller->email,
                    'commission' => $sale->commission,
                ],
            ]);
    }

    public function test_should_create_seller_response_http_code_201(): void
    {
        $name = 'Name-Test';

        $payload = [
            'name' => $name,
            'email' => 'mail@mail.com',
        ];

        $this->post('api/seller', $payload)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
                'created_at',
            ]);

        $this->assertDatabaseCount('sellers', 1);
        $this->assertDatabaseHas('sellers', ['name' => $name, ]);
    }

    public function test_should_create_seller_without_correct_payload_response_http_code_422(): void
    {
        $this->post('api/seller', [])
            ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonFragment(['message' => 'The name field is required.']);

        $this->assertDatabaseCount('sales', 0);
    }

    public function test_should_show_seller_by_id_and_response_http_code_200(): void
    {
        $seller = Seller::factory()->create();

        $this->get('api/seller/' . $seller->id)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                [
                    'id',
                    'name',
                    'email',
                ],
            ]);
    }

    public function test_should_show_seller_by_id_and_response_http_code_404_not_found(): void
    {
        $this->get('api/seller/' . 0)
            ->assertStatus(Response::HTTP_NOT_FOUND)
            ->assertJsonFragment([
                'shortMessage' => Exceptions::NOT_FOUND,
                'message' => Lang::get('exceptions.' . Exceptions::NOT_FOUND),
                'httpCode' => Response::HTTP_NOT_FOUND,
            ]);
    }

    public function test_should_response_http_code_200_when_edit_seller(): void
    {
        $seller = Seller::factory()->create();

        $this->get('api/seller/' . $seller->id . '/edit')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'name',
                'email',
            ]);
    }

    public function test_should_response_http_code_200_when_update_seller(): void
    {
        $name   = 'Update-Name-Test';
        $seller = Seller::factory()->create();

        $this->put('api/seller/' . $seller->id, ['name' => $name, ])
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment(['message' => Lang::get('messages.' . Messages::SELLER_UPDATED)]);

        $this->assertDatabaseHas('sellers', ['name' => $name, ]);
    }

    public function test_should_response_http_code_200_when_delete_sale(): void
    {
        $seller = Seller::factory()->create();

        $this->delete('api/seller/' . $seller->id)
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment(['message' => Lang::get('messages.' . Messages::SELLER_DELETED)]);

        $this->assertSoftDeleted($seller);
    }
}
