<?php

namespace Remils\LaravelTinkoff\Contracts;

use Illuminate\Support\Collection;

interface Tinkoff
{
    public function init(
        int $amount,
        string $orderId,
        string $description,
        array $receipt,
        string $notificationUrl,
        string $successUrl,
        string $failUrl,
        string $ip,
        string $customerKey,
        int $currency,
        string $language,
        array $data
    ): Collection;

    public function confirm(
        int $paymentId,
        string $ip,
        int $amount,
        array $receipt
    ): Collection;

    public function cancel(
        int $paymentId,
        string $ip,
        int $amount,
        array $receipt
    ): Collection;

    public function getState(
        int $paymentId,
        string $ip
    ): Collection;

    public function checkOrder(
        string $orderId
    ): Collection;

    public function addCustomer(
        string $customerKey,
        string $ip,
        string $email,
        string $phone
    ): void;

    public function getCustomer(
        string $customerKey,
        string $ip
    ): Collection;

    public function removeCustomer(
        string $customerKey,
        string $ip
    ): void;

    public function addCard(
        string $customerKey,
        string $checkType,
        bool $residentState,
        string $ip
    ): Collection;

    public function getAddCardState(
        string $requestKey
    ): Collection;

    public function getCardList(
        string $customerKey,
        string $ip
    ): Collection;

    public function removeCard(
        string $customerKey,
        string $cardId,
        string $ip
    ): Collection;
}
