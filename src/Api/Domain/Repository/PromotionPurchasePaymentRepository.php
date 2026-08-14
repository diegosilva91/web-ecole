<?php

namespace Mi-empresa\Api\Domain\Repository;

use App\PromotionPurchasePayment;

interface PromotionPurchasePaymentRepository
{
    public function findBySubscriptionToken(string $subscriptionToken): ?PromotionPurchasePayment;

    public function findPaymentBySubscriptionAndStatus(string $subscriptionToken, array $paymentStatus): ?PromotionPurchasePayment;

    public function findPreparedSubscriptionByToken(string $subscriptionToken): ?PromotionPurchasePayment;

    public function findByPaymentIntentAndPaymentStatus(string $paymentIntentToken, array $paymentStatus): ?PromotionPurchasePayment;

    public function createByData(array $data);

    public function update(array $dataFind, array $dataUpdate): void;
}
