<?php

use Mgcodeur\CurrencyConverter\CurrencyConverter;
use Mgcodeur\CurrencyConverter\Services\CurrencyService;

beforeEach(function () {
    $this->currencyServiceMock = $this->mock(CurrencyService::class);
});

test('convert sets the amount using convert method and returns self', function () {
    $currencyConverter = app(CurrencyConverter::class);
    expect($currencyConverter->convert(100))->toBeInstanceOf(CurrencyConverter::class);
});

test('amount sets the amount using amount method and returns self', function () {
    $currencyConverter = app(CurrencyConverter::class);
    expect($currencyConverter->amount(100))->toBeInstanceOf(CurrencyConverter::class);
});

test('sets the from currency using from method and returns self', function () {
    $currencyConverter = app(CurrencyConverter::class);
    expect($currencyConverter->from('USD'))->toBeInstanceOf(CurrencyConverter::class);
});

test('sets the to currency using to method and returns self', function () {
    $currencyConverter = app(CurrencyConverter::class);
    expect($currencyConverter->to('USD'))->toBeInstanceOf(CurrencyConverter::class);
});

test('throws MissingAmountException when getting conversion without setting amount', function () {
    $currencyConverter = app(CurrencyConverter::class);

    $currencyConverter->get();
})->throws(\Mgcodeur\CurrencyConverter\Exceptions\MissingAmountException::class);

test('throw MissingCurrencyException if we don\'t specify from currency', function () {
    $currencyConverter = app(CurrencyConverter::class);

    $currencyConverter
        ->convert(10)
        ->to('usd')
        ->get();
})->throws(\Mgcodeur\CurrencyConverter\Exceptions\MissingCurrencyException::class);

test('convert currency from USD to EUR', function () {
    // example of value of 1 USD in EUR
    $dataToMock = [
        'eur' => 0.92326769,
    ];

    $amountToConvert = 100;

    $convertedAmount = 0.92326769 * $amountToConvert;

    $mockedResponse = new \Illuminate\Http\Client\Response(
        new \GuzzleHttp\Psr7\Response(200, [], json_encode($dataToMock))
    );

    $this->currencyServiceMock
        ->shouldReceive('runConversionFrom')
        ->with('usd', 'eur')
        ->andReturn($mockedResponse);

    $currencyConverter = app(CurrencyConverter::class);
    $convertedAmount = $currencyConverter->from('usd')
        ->to('eur')
        ->convert($amountToConvert)
        ->get();

    expect($convertedAmount)->toBeFloat()->toEqual($convertedAmount);
});

test('convert currency from USD to all supported currencies', function () {
    // example of value of 1 USD in [eur, mga, btc]
    $dataToMock = [
        'usd' => [
            'eur' => 0.92326769,
            'mga' => 4511.5880329,
            'btc' => 0.0000229836,
        ],
    ];

    $amountToConvert = 100;

    $convertedAmount = array_map(fn ($value) => $value * $amountToConvert, $dataToMock['usd']);

    $response = new \Illuminate\Http\Client\Response(
        new \GuzzleHttp\Psr7\Response(200, [], json_encode($dataToMock))
    );

    $mockedResponse = $response->json();

    $this->currencyServiceMock
        ->shouldReceive('runConversionFrom')
        ->with('usd', Mockery::any())
        ->andReturn($mockedResponse);

    $this->currencyServiceMock
        ->shouldReceive('convertAllCurrency')
        ->with(
            100,
            $dataToMock['usd'],
            false
        )
        ->andReturn($convertedAmount);

    $currencyConverter = app(CurrencyConverter::class);

    $testResult = $currencyConverter->from('usd')
        ->convert(100)
        ->get();

    expect($testResult)->toBeArray()->toEqual($convertedAmount);
});

test('fetch a list of all supported currencies', function () {
    $dataToMock = [
        '1000SATS' => '',
        '1INCH' => '1inch',
        'AAVE' => 'Aave',
        'MGA' => 'Malagasy Ariary',
    ];

    $mockedResponse = new \Illuminate\Http\Client\Response(
        new \GuzzleHttp\Psr7\Response(200, [], json_encode($dataToMock))
    );

    $this->currencyServiceMock
        ->shouldReceive('fetchAllCurrencies')
        ->andReturn($mockedResponse);

    $currencyConverter = app(CurrencyConverter::class);

    $testResult = $currencyConverter->currencies()->get();

    expect($testResult)->toBeArray()->toEqual($dataToMock);
});

test('throw NetworkException when fetching a list of all supported currencies has no response or fail', function () {
    $mockedResponse = new \Illuminate\Http\Client\Response(
        new \GuzzleHttp\Psr7\Response(500, [], '')
    );

    $this->currencyServiceMock
        ->shouldReceive('fetchAllCurrencies')
        ->andReturn($mockedResponse);

    $currencyConverter = app(CurrencyConverter::class);

    $currencyConverter->currencies()->get();
})->throws(\Mgcodeur\CurrencyConverter\Exceptions\NetworkException::class);
