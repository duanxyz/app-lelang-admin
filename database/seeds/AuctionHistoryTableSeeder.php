<?php

use App\Laravue\Models\Auction_history;
use Illuminate\Database\Seeder;

class AuctionHistoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Auction_history::class, 20)->create();

    }
}
