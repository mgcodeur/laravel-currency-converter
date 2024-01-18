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

test('get conversion without setting amount throws exception', function () {
    $currencyConverter = app(CurrencyConverter::class);

    $currencyConverter->get();
})->throws(Exception::class);

test('convert currency from USD to EUR', function () {
    $mockResponse = new \Illuminate\Http\Client\Response(
        new \GuzzleHttp\Psr7\Response(200, [], json_encode(['eur' => 2000.0]))
    );

    $this->currencyServiceMock
        ->shouldReceive('runConversionFrom')
        ->with('usd', 'eur')
        ->andReturn($mockResponse);

    $currencyConverter = app(CurrencyConverter::class);
    $convertedAmount = $currencyConverter->from('USD')
        ->to('EUR')
        ->convert(100)
        ->get();

    expect($convertedAmount)->toBeFloat()->toEqual(2000.0 * 100);
});
