<?php

namespace Remils\LaravelTinkoff;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Collection init(int $amount, string $orderId, string $description = null, array $receipt = null, string $notificationUrl = null, string $successUrl = null, string $failUrl = null, string $ip = null, string $customerKey = null, int $currency = null, string $language = null, array $data = null)
 * @method static Collection confirm(int $paymentId, string $ip = null, int $amount = null, array $receipt = null)
 * @method static Collection cancel(int $paymentId, string $ip = null, int $amount = null, array $receipt = null)
 * @method static Collection getState(int $paymentId, string $ip = null)
 * @method static Collection checkOrder(string $orderId)
 * @method static void       addCustomer(string $customerKey, string $ip = null, string $email = null, string $phone = null)
 * @method static Collection getCustomer(string $customerKey, string $ip = null)
 * @method static void       removeCustomer(string $customerKey, string $ip = null)
 * @method static Collection addCard(string $customerKey, string $checkType = null, bool $residentState = null, string $ip = null)
 * @method static Collection getAddCardState(string $requestKey)
 * @method static Collection getCardList(string $customerKey, string $ip = null)
 * @method static Collection removeCard(string $customerKey, string $cardId, string $ip = null)
 */
class Tinkoff extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tinkoff';
    }
}
