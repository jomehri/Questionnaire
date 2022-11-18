<?php

namespace Tests\Feature\App;

use App\Jobs\Sale\BuyFromExchangeJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;
use Tests\BaseTest;
use App\Models\Sale\Coin;
use App\Models\Basic\User;

class UserCoinPurchaseTest extends BaseTest
{

    /**
     * @return void
     */
    public function test_validation_throws_exception_on_bad_coin_name(): void
    {
        $this->initializeFactorySeeds();

        $data = [
            'amount' => 3,
        ];

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $this->putJson('/api/user/coins/purchase', $data, $headers)->assertStatus(422);
    }

    /**
     * @return void
     */
    public function test_validation_throws_exception_on_bad_amount(): void
    {
        $this->initializeFactorySeeds();

        $data = [
            'coinName' => "ABAN",
        ];

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $this->putJson('/api/user/coins/purchase', $data, $headers)->assertStatus(422);
    }

    /**
     * @return void
     */
    public function test_endpoint_is_ok_with_correct_data(): void
    {
        $this->initializeFactorySeeds();

        $data = [
            'coinName' => "ABAN",
            'amount' => 3,
        ];

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $this->putJson('/api/user/coins/purchase', $data, $headers)->assertOk();
    }

    /**
     * @return void
     */
    public function test_http_buy_from_exchange_job_dispatches_on_amounts_less_than_10_dollars(): void
    {
        Bus::fake();

        $this->initializeFactorySeeds();

        $data = [
            'coinName' => "ABAN",
            'amount' => 9,
        ];

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $this->putJson('/api/user/coins/purchase', $data, $headers);

        Bus::assertNotDispatched(BuyFromExchangeJob::class);
    }

    /**
     * @return void
     */
    public function test_http_buy_from_exchange_job_dispatches_on_amounts_greater_than_10_dollars(): void
    {
        Bus::fake();

        $this->initializeFactorySeeds();

        $data = [
            'coinName' => "ABAN",
            'amount' => 11,
        ];

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $this->putJson('/api/user/coins/purchase', $data, $headers);
        $this->putJson('/api/user/coins/purchase', $data, $headers);

        Bus::assertNotDispatched(BuyFromExchangeJob::class);
    }

    /**
     * @return void
     */
    private function initializeFactorySeeds(): void
    {
        User::factory(1)->create();
        Coin::factory(1)
            ->abanCoin()
            ->enabled()
            ->create();
    }

}
