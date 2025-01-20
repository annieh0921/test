<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserSubscription\SubscribeRequest;
use App\Http\Requests\UserSubscription\UnSubscribeRequest;
use App\Http\Resources\Subscription\SubscriptionResource;
use App\Http\Resources\Subscription\UserSubscriptionResource;
use App\Http\Resources\Success\SuccessResource;
use App\Services\Subscription\SubscriptionService;
use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class SubscriptionController extends Controller
{
    /**
     * @param SubscribeRequest $request
     * @param SubscriptionService $userSubscriptionService
     * @return SuccessResource
     * @throws Exception
     */
    public function subscribe(
        SubscribeRequest $request,
        SubscriptionService $userSubscriptionService
    ): SuccessResource {
        $userSubscriptionService->subscribe($request->getSubscriptionId());

        return new SuccessResource([true]);
    }

    /**
     * @param UnSubscribeRequest $request
     * @param SubscriptionService $userSubscriptionService
     * @return SuccessResource
     * @throws Exception
     */
    public function unsubscribe(
        UnSubscribeRequest $request,
        SubscriptionService $userSubscriptionService
    ): SuccessResource {
        $userSubscriptionService->unsubscribe($request->getSubscriptionId());

        return new SuccessResource([true]);
    }

    /*** @throws Exception */
    public function show(SubscriptionService $subscriptionService): UserSubscriptionResource
    {
        $result = $subscriptionService->show();

        return new UserSubscriptionResource($result);
    }

    /**
     * @param SubscriptionService $subscriptionService
     * @return AnonymousResourceCollection
     */
    public function index(SubscriptionService $subscriptionService): AnonymousResourceCollection
    {
        $result = $subscriptionService->index();

        return SubscriptionResource::collection($result);
    }
}
