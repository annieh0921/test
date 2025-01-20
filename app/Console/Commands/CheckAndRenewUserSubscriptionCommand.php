<?php

namespace App\Console\Commands;

use App\Jobs\CheckAndRenewUserSubscriptionJob;
use App\Models\Subscription\Subscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckAndRenewUserSubscriptionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-and-renew-user-subscription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and renew user subscription';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $userIds = User::query()->whereHas('subscriptions', function ($query) {
            $query->where('user_subscriptions.status', Subscription::STATUS_ACTIVE)
                ->whereBetween('user_subscriptions.expired_at', [
                    Carbon::now()->startOfDay(),
                    Carbon::now()->addDay()->endOfDay(),
                ]);
        })->pluck('id');

        foreach ($userIds as $id) {
            CheckAndRenewUserSubscriptionJob::dispatch($id);
        }
    }
}
