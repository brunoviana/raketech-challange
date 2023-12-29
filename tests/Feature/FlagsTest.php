<?php

namespace Tests\Feature;

use App\Models\User;
use App\Raketech\FlagProviderInterface;
use App\Raketech\FlagsCollection;
use App\Raketech\FlagsCollectionInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FlagsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_controller_should_return_data_from_rest_countries_successfully()
    {
        // Arrange
        Http::fake([
            'https://restcountries.com/v3.1/all*' => Http::response($this->getAllFlagsResponse(), 200),
            'https://restcountries.com/v3.1/capital/lisbon*' => Http::response(null, 200),
        ]);


        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user, 'auth0-api')
                            ->get('/api/flags');

        // Assert
        $response->assertStatus(200)
            ->assertExactJson([
                [
                    'country_name' => 'Christmas Island',
                    'url' => 'https://flagcdn.com/w320/cx.png'
                ]
            ]);
    }

    public function test_controller_should_empty_response_if_not_working_provider_is_found()
    {
        // Arrange
        Http::fake([
            'https://restcountries.com/v3.1/capital/lisbon*' => Http::response(null, 500),
        ]);

        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user, 'auth0-api')
            ->get('/api/flags');

        // Assert
        $response->assertStatus(200)
            ->assertExactJson([]);
    }

    public function test_controller_should_try_another_adapter_if_default_fail()
    {
        // Arrange
        $class = new class implements FlagProviderInterface {
            public function provide(): FlagsCollectionInterface
            {
                return new FlagsCollection();
            }

            public function testConnection(): bool
            {
                return false;
            }
        };

        config()->set('flags.default_provider', 'test');
        config()->set('flags.providers', [
            'rest_countries' => \App\Raketech\Adapter\RestCountriesProviderAdapter::class,
            'test' => $class::class
        ]);

        Http::fake([
            'https://restcountries.com/v3.1/all*' => Http::response($this->getAllFlagsResponse(), 200),
            'https://restcountries.com/v3.1/capital/lisbon*' => Http::response(null, 200),
        ]);

        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user, 'auth0-api')
            ->get('/api/flags');

        // Assert
        $response->assertStatus(200)
            ->assertExactJson([
                [
                    'country_name' => 'Christmas Island',
                    'url' => 'https://flagcdn.com/w320/cx.png'
                ]
            ]);
    }

    private function getAllFlagsResponse(): array
    {
        return [
            [
                "flags" => [
                    "png" => "https://flagcdn.com/w320/cx.png",
                    "svg" => "https://flagcdn.com/cx.svg1",
                    "alt" => ""
                ],
                "name" => [
                    "common" => "Christmas Island",
                    "official" =>"Territory of Christmas Island",
                    "nativeName" => [
                        "eng" => [
                            "official" => "Territory of Christmas Island",
                            "common" => "Christmas Island"
                        ]
                    ],
                ]
            ]
        ];
    }

}
