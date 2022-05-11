# Laravel Tinkoff

## Install

```ssh
composer require remils/laravel-tinkoff
```

```ssh
php artisan vendor:publish --force --provider="Remils\LaravelTinkoff\TinkoffProvider" --tag="config"
```

Add provider to file /config/app.php

```php
return [
    ...
    'providers' => [
        ...
        Remils\LaravelTinkoff\TinkoffProvider::class,
    ],
    ...
];
```

Customize settings to file /.env

```
...
TINKOFF_URL=https://rest-api-test.tinkoff.ru
TINKOFF_KEY=TinkoffBankTest
TINKOFF_PASSWORD=TinkoffBankTest
```

## Example

```php
use Remils\LaravelTinkoff\Facades\Tinkoff;

Tinkoff::init(
  140000,
  '21050',
  'Gift card for 1400.00 rubles',
  [
    'Email' => 'a@test.ru',
    'Phone' => '+79031234567',
    'EmailCompany' => 'b@test.ru'
    'Taxation' => 'osn',
    'Items' => [
      [
        'Name' => 'Product name 1.',
        'Price' => 10000,
        'Quantity' => 1.00,
        'Amount' => 10000,
        'PaymentMethod' => 'full_prepayment',
        'PaymentObject' => 'commodity',
        'Tax' => 'vat10',
        'Ean13' => '0123456789',
      ],
      [
        'Name' => 'Product Name 2.',
        'Price' => 20000,
        'Quantity' => 2.00,
        'Amount' => 40000,
        'PaymentMethod' => 'prepayment',
        'PaymentObject' => 'service',
        'Tax' => 'vat20',
      ],
      [
        'Name' => 'Product Name 3.',
        'Price' => 30000,
        'Quantity' => 3.00,
        'Amount' => 90000,
        'Tax' => 'vat10',
      ]
    ]
  ]
);
```

## License

Copyright (c) Zatulivetrov Sergey. Distributed under the MIT.
