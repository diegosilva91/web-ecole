<?php

namespace Mi-empresa\Api\Infrastructure\Persistence\Eloquent;

use App\PromotionPurchasePayment;
use Mi-empresa\Api\Domain\Repository\PromotionPurchasePaymentRepository;
use Mi-empresa\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentPromotionPurchasePaymentRepository extends EloquentRepository implements PromotionPurchasePaymentRepository
{
    public function findBySubscriptionToken(string $subscriptionToken): ?PromotionPurchasePayment
    {
        return $this->model
            ->where(['stripe_subscription_token' => $subscriptionToken])
            ->orderBy('id','desc')
            ->first();
    }

    public function findPaymentBySubscriptionAndStatus(string $subscriptionToken, array $paymentStatus): ?PromotionPurchasePayment
    {
        return $this->model
            ->where(['stripe_subscription_token' => $subscriptionToken])
            ->whereIn('payment_status', $paymentStatus)
            ->orderBy('id','desc')
            ->first();
    }

    public function findPreparedSubscriptionByToken(string $subscriptionToken): ?PromotionPurchasePayment
    {
        return $this->model
            ->where('stripe_subscription_token', '=', $subscriptionToken)
            ->whereIn('payment_status', ['prepared','failed','error'])
            ->orderBy('id','desc')
            ->first();
    }

    public function findByPaymentIntentAndPaymentStatus(string $paymentIntentToken, array $paymentStatus): ?PromotionPurchasePayment
    {
        $query = $this->model
            ->where(['stripe_payment_intent_token' => $paymentIntentToken])
            ->orderBy('id','desc');

        if (count($paymentStatus) > 0) {
            $query = $query->whereIn('payment_status', $paymentStatus);
        }

        return $query->first();
    }

    public function createByData(array $data)
    {
        $this->model->create($data);
    }

    public function update(array $dataFind, array $dataUpdate): void
    {
        $model = PromotionPurchasePayment::where($dataFind);
        $model->update($dataUpdate);
    }

    protected function model(): string
    {
        return PromotionPurchasePayment::class;
    }
}
