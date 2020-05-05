<?php

use App\Laravue\Models\Member;
use App\Laravue\Models\Wallet;
use Illuminate\Database\Seeder;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Member::class, 50)->create()->each(function ($member) {
            // $member->identity()->save(factory(Identity::class)->make());
            $wallet = factory(Wallet::class)->make();
            $member->wallet()->save($wallet);

            // $wallet->each(function ($walle) {
            //     $walle->withdraw()->save(factory(Withdrawal_information::class)->make());
            //     $walle->deposit()->save(factory(Deposit_information::class)->make());
            //     $walle->spending()->save(factory(Spending::class)->make());
            // });
        });
    }
}
