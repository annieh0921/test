<?php

namespace App\Jobs;

use App\Models\Subscription\Subscription;
use App\Models\UserSubscription\UserSubscription;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CheckAndRenewUserSubscriptionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $userId
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $userSubscription = UserSubscription::query()
            ->where('user_id', $this->userId)
            ->where('status', Subscription::STATUS_ACTIVE)
            ->first();
        if (!$userSubscription) {
            return;
        }

        $userSubscription->lockForUpdate();
        if (rand(0, 1) === 0) {
            Log::info("Unable to renew subscription for user #{$this->userId}: insufficient funds.");

            if ($userSubscription->start_at && Carbon::parse($userSubscription->start_at)->addDays(30)->equalTo(Carbon::now())) {
                $userSubscription->status = Subscription::STATUS_INACTIVE;
                Log::info("User subscription #{$userSubscription->user_id} became inactive because more than 30 days have passed since the start.");
                $userSubscription->save();
            }

        }

        $userSubscription->start_at = Carbon::now();
        $userSubscription->expired_at = Carbon::now()->addDays(30);
        $userSubscription->save();
    }
}
