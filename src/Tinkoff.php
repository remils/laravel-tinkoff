<?php

namespace Remils\LaravelTinkoff;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Remils\LaravelTinkoff\Contracts\Tinkoff as TinkoffContract;
use Remils\LaravelTinkoff\Dto\TerminalDto;
use Remils\LaravelTinkoff\Exceptions\TinkoffException;

class Tinkoff implements TinkoffContract
{
    protected $terminal;

    public function __construct(TerminalDto $terminal)
    {
        $this->terminal = $terminal;
    }

    public function init(
        int $amount,
        string $orderId,
        string $description = null,
        array $receipt = null,
        string $notificationUrl = null,
        string $successUrl = null,
        string $failUrl = null,
        string $ip = null,
        string $customerKey = null,
        int $currency = null,
        string $language = null,
        array $data = null
    ): Collection {
        return $this->execute(
            'Init',
            $this->initData(
                [
                    'Amount' => $amount,
                    'OrderId' => $orderId,
                ],
                function (Collection $items) use (
                    $description,
                    $receipt,
                    $notificationUrl,
                    $successUrl,
                    $failUrl,
                    $ip,
                    $customerKey,
                    $currency,
                    $language,
                    $data
                ) {
                    if ($description) {
                        $items->put('Description', $description);
                    }

                    if ($receipt) {
                        $items->put('Receipt', $receipt);
                    }

                    if ($notificationUrl) {
                        $items->put('NotificationURL', $notificationUrl);
                    }

                    if ($successUrl) {
                        $items->put('SuccessURL', $successUrl);
                    }

                    if ($failUrl) {
                        $items->put('FailURL', $failUrl);
                    }

                    if ($ip) {
                        $items->put('IP', $ip);
                    }

                    if ($customerKey) {
                        $items->put('CustomerKey', $customerKey);
                    }

                    if ($currency) {
                        $items->put('Currency', $currency);
                    }

                    if ($language) {
                        $items->put('Language', $language);
                    }

                    if ($data) {
                        $items->put('DATA', $data);
                    }
                }
            )
        )->only('Status', 'PaymentId', 'PaymentURL');
    }

    public function confirm(int $paymentId, string $ip = null, int $amount = null, array $receipt = null): Collection
    {
        return $this->execute(
            'Confirm',
            $this->initData(
                [
                    'PaymentId' => $paymentId,
                ],
                function (Collection $items) use ($ip, $amount, $receipt) {
                    if ($ip) {
                        $items->put('IP', $ip);
                    }

                    if ($amount) {
                        $items->put('Amount', $amount);
                    }

                    if ($receipt) {
                        $items->put('Receipt', $receipt);
                    }
                }
            )
        )->only('OrderId', 'Status');
    }

    public function cancel(int $paymentId, string $ip = null, int $amount = null, array $receipt = null): Collection
    {
        return $this->execute(
            'Cancel',
            $this->initData(
                [
                    'PaymentId' => $paymentId,
                ],
                function (Collection $items) use ($ip, $amount, $receipt) {
                    if ($ip) {
                        $items->put('IP', $ip);
                    }

                    if ($amount) {
                        $items->put('Amount', $amount);
                    }

                    if ($receipt) {
                        $items->put('Receipt', $receipt);
                    }
                }
            )
        )->only('OrderId', 'Status', 'OriginalAmount', 'NewAmount');
    }

    public function getState(int $paymentId, string $ip = null): Collection
    {
        return $this->execute(
            'GetState',
            $this->initData(
                [
                    'PaymentId' => $paymentId,
                ],
                function (Collection $items) use ($ip) {
                    if ($ip) {
                        $items->put('IP', $ip);
                    }
                }
            )
        )->only('OrderId', 'Status', 'Amount');
    }

    public function checkOrder(string $orderId): Collection
    {
        return $this->execute(
            'CheckOrder',
            $this->initData(
                [
                    'OrderID' => $orderId,
                ]
            )
        )->only('Payments');
    }

    public function addCustomer(
        string $customerKey,
        string $ip = null,
        string $email = null,
        string $phone = null
    ): void {
        $this->execute(
            'AddCustomer',
            $this->initData(
                [
                    'CustomerKey' => $customerKey,
                ],
                function (Collection $items) use ($ip, $email, $phone) {
                    if ($ip) {
                        $items->put('IP', $ip);
                    }

                    if ($email) {
                        $items->put('Email', $email);
                    }

                    if ($phone) {
                        $items->put('Phone', $phone);
                    }
                }
            )
        );
    }

    public function getCustomer(string $customerKey, string $ip = null): Collection
    {
        return $this->execute(
            'GetCustomer',
            $this->initData(
                [
                   'CustomerKey' => $customerKey,
                ],
                function (Collection $items) use ($ip) {
                    if ($ip) {
                        $items->put('IP', $ip);
                    }
                }
            )
        )->only('Email', 'Phone');
    }

    public function removeCustomer(string $customerKey, string $ip = null): void
    {
        $this->execute(
            'RemoveCustomer',
            $this->initData(
                [
                    'CustomerKey' => $customerKey,
                ],
                function (Collection $items) use ($ip) {
                    if ($ip) {
                        $items->put('IP', $ip);
                    }
                }
            )
        );
    }

    public function addCard(
        string $customerKey,
        string $checkType = null,
        bool $residentState = null,
        string $ip = null
    ): Collection {
        return $this->execute(
            'AddCard',
            $this->initData(
                [
                    'CustomerKey' => $customerKey,
                ],
                function (Collection $items) use ($checkType, $residentState, $ip) {
                    if ($checkType) {
                        $items->put('CheckType', $checkType);
                    }

                    if ($residentState) {
                        $items->put('ResidentState', $residentState);
                    }

                    if ($ip) {
                        $items->put('IP', $ip);
                    }
                }
            )
        )->only('RequestKey', 'PaymentURL');
    }

    public function getAddCardState(string $requestKey): Collection
    {
        return $this->execute(
            'GetAddCardState',
            $this->initData([
                'RequestKey' => $requestKey
            ])
        )->only('Status', 'CustomerKey', 'CardId', 'RebillId');
    }

    public function getCardList(string $customerKey, string $ip = null): Collection
    {
        return $this->execute(
            'GetCardList',
            $this->initData(
                [
                    'CustomerKey' => $customerKey,
                ],
                function (Collection $items) use ($ip) {
                    if ($ip) {
                        $items->put('IP', $ip);
                    }
                }
            )
        );
    }

    public function removeCard(string $customerKey, string $cardId, string $ip = null): Collection
    {
        return $this->execute(
            'RemoveCard',
            $this->initData(
                [
                    'CustomerKey' => $customerKey,
                    'CardId' => $cardId,
                ],
                function (Collection $items) use ($ip) {
                    if ($ip) {
                        $items->put('IP', $ip);
                    }
                }
            )
        )->only('Status', 'CardType');
    }

    protected function initData(array $items, Closure $callback = null): Collection
    {
        $data = new Collection($items);

        $data->put('TerminalKey', $this->terminal->getKey());

        if ($callback) {
            call_user_func($callback, $data);
        }

        return $data;
    }

    protected function generateToken(Collection $data): void
    {
        $data->put('Token', hash('sha256', join(
            '',
            $data->except(['Receipt', 'DATA'])
                ->put('Password', $this->terminal->getPassword())
                ->sortKeys()
                ->toArray()
        )));
    }

    protected function execute(string $action, Collection $data): Collection
    {
        $this->generateToken($data);

        $response = Http::asJson()
            ->post(
                sprintf('%s/v2/%s', $this->terminal->getUrl(), $action),
                $data->toArray()
            );

        $body = json_decode($response->body(), true);

        $result = new Collection($body);

        if ($result->get('Success')) {
            return $result;
        }

        throw new TinkoffException(
            $result->get('Details'),
            $result->get('ErrorCode')
        );
    }
}
