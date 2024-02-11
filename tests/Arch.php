<?php

use Gemini\Contracts\ResponseContract;
use Gemini\Contracts\TransporterContract;
use Gemini\Foundation\Request;

test('contracts')
    ->expect('Gemini\Contracts')
    ->toBeInterfaces();

test('enums')
    ->expect('Gemini\Enums')
    ->toBeEnums();

test('exceptions')
    ->expect('Gemini\Exceptions')
    ->toImplement(Throwable::class);

test('foundation')
    ->expect('Gemini\Foundation')
    ->toBeAbstract();

test('requests')
    ->expect('Gemini\Requests')
    ->toExtend(Request::class)
    ->ignoring('Gemini\Requests\Concerns');

test('resources')
    ->expect('Gemini\Resources')
    ->toBeClasses()
    ->toBeFinal();

test('responses')
    ->expect('Gemini\Responses')
    ->toImplement(ResponseContract::class)
    ->ignoring('Gemini\Responses\StreamResponse');

test('transporters')
    ->expect('Gemini\Transporters')
    ->toImplement(TransporterContract::class)
    ->ignoring('Gemini\Transporters\DTOs');
