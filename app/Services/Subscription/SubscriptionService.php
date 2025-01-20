<?php

namespace App\Services\Subscription;

use App\Models\Subscription\Subscription;
use App\Models\User;
use App\Models\UserSubscription\UserSubscription;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class SubscriptionService
{
    /*** @throws Exception */
    public function subscribe(int $subscriptionId): void
    {

        $user = Auth::user();
        /**@var User $user */
        if ($user->subscriptions()->where('user_subscriptions.status', Subscription::STATUS_ACTIVE)->exists()) {
            throw new Exception('You have active subscription');
        }

        $data = [
            $subscriptionId => [
                'start_at' => Carbon::now(),
                'expired_at' => Carbon::now()->addDays(30),
                'status' => Subscription::STATUS_ACTIVE
            ]
        ];
        /**@var User $user */
        $user->subscriptions()->attach($data);

    }

    /*** @throws Exception */
    public function unsubscribe(int $subscriptionId): void
    {
        $user = Auth::user();
        $userSubscription = UserSubscription::query()
            ->where('status', Subscription::STATUS_ACTIVE)
            ->where('user_id', $user->id)
            ->where('subscription_id', $subscriptionId)
            ->first();
        if (!$userSubscription) {
            throw new Exception('Failed to unsubscribe');
        }

        $userSubscription->lockForUpdate();
        $userSubscription->status = Subscription::STATUS_CANCELED;
        $userSubscription->save();
    }

    public function index(): Collection
    {
        return Subscription::query()->get();
    }

    /**
     * @throws Exception
     */
    public function show(): UserSubscription
    {
        /**@var UserSubscription $subscription */
        $subscription =  UserSubscription::query()
            ->where('user_id', Auth::user()->id)
            ->where('status', Subscription::STATUS_ACTIVE)
            ->with('subscription')
            ->first();
        if (!$subscription) {
            throw new Exception('Subscription not found');
        }

        return $subscription;
    }
}
