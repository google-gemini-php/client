<?php

use Gemini\Data\Candidate;
use Gemini\Data\PromptFeedback;
use Gemini\Data\UsageMetadata;
use Gemini\Enums\Method;
use Gemini\Resources\ChatSession;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\Utils;

test('send message', function () {
    $client = mockClient(method: Method::POST, endpoint: 'generateContent', response: GenerateContentResponse::fake(), times: 0);

    $result = $client->generativeModel('models/gemini-1.5-flash')->startChat();

    expect($result)
        ->toBeInstanceOf(ChatSession::class);
});

test('start chat', function () {
    $client = mockClient(method: Method::POST, endpoint: 'models/gemini-1.5-flash:generateContent', response: GenerateContentResponse::fake(), times: 0);

    $result = $client->chat('models/gemini-1.5-flash')->startChat();

    expect($result)
        ->toBeInstanceOf(ChatSession::class);
});

test('stream send message', function () {
    $response = new Response(
        body: new Stream(
            GenerateContentResponse::fakeResource()
        ),
    );

    $modelType = 'models/gemini-1.5-flash';
    $client = mockStreamClient(method: Method::POST, endpoint: "{$modelType}:streamGenerateContent", response: $response);

    $chat = $client->generativeModel($modelType)->startChat();
    $result = $chat->streamSendMessage('Hello');

    expect($result)
        ->toBeInstanceOf(Generator::class)
        ->toBeInstanceOf(Iterator::class)
        ->and($result->current())
        ->toBeInstanceOf(GenerateContentResponse::class)
        ->candidates->toBeArray()->each->toBeInstanceOf(Candidate::class)
        ->promptFeedback->toBeInstanceOf(PromptFeedback::class)
        ->usageMetadata->toBeInstanceOf(UsageMetadata::class)
        ->and($chat->history)->toHaveCount(1);

});

function streamedChatResponse(array $chunks): Response
{
    $chunks = array_map(fn (array $parts): array => [
        'candidates' => [['content' => ['parts' => $parts, 'role' => 'model'], 'index' => 0]],
        'usageMetadata' => ['promptTokenCount' => 1, 'totalTokenCount' => 2],
    ], $chunks);

    return new Response(body: Utils::streamFor(json_encode($chunks)));
}

test('stream send message joins text chunks into one part', function () {
    $client = mockStreamClient(method: Method::POST, endpoint: 'models/gemini-2.5-flash:streamGenerateContent', response: streamedChatResponse([
        [['text' => 'Hel']],
        [['text' => 'lo']],
        [['text' => '!', 'thoughtSignature' => 'c2ln']],
    ]));

    $chat = $client->generativeModel('models/gemini-2.5-flash')->startChat();
    iterator_to_array($chat->streamSendMessage('Hi'));

    expect($chat->history[1]->toArray()['parts'])
        ->toBe([['text' => 'Hello!', 'thoughtSignature' => 'c2ln']]);
});

test('stream send message keeps tool call and tool response parts', function () {
    $client = mockStreamClient(method: Method::POST, endpoint: 'models/gemini-2.5-flash:streamGenerateContent', response: streamedChatResponse([
        [['thoughtSignature' => 'c2lnMQ==', 'toolCall' => ['toolType' => 'URL_CONTEXT', 'args' => ['urls' => ['https://example.com']], 'id' => 'call_1']]],
        [['thoughtSignature' => 'c2lnMg==', 'toolResponse' => ['toolType' => 'URL_CONTEXT', 'response' => ['status' => 'ok'], 'id' => 'call_1']]],
        [['text' => 'Example ']],
        [['text' => 'Domain.']],
    ]));

    $chat = $client->generativeModel('models/gemini-2.5-flash')->startChat();
    iterator_to_array($chat->streamSendMessage('Summarize https://example.com'));

    expect($chat->history[1]->toArray()['parts'])
        ->toBe([
            ['thoughtSignature' => 'c2lnMQ==', 'toolCall' => ['toolType' => 'URL_CONTEXT', 'args' => ['urls' => ['https://example.com']], 'id' => 'call_1']],
            ['thoughtSignature' => 'c2lnMg==', 'toolResponse' => ['toolType' => 'URL_CONTEXT', 'response' => ['status' => 'ok'], 'id' => 'call_1']],
            ['text' => 'Example Domain.'],
        ]);
});

test('stream send message keeps thoughts and answer apart', function () {
    $client = mockStreamClient(method: Method::POST, endpoint: 'models/gemini-2.5-flash:streamGenerateContent', response: streamedChatResponse([
        [['text' => 'Thinking ', 'thought' => true]],
        [['text' => 'more.', 'thought' => true]],
        [['text' => 'Answer.']],
    ]));

    $chat = $client->generativeModel('models/gemini-2.5-flash')->startChat();
    iterator_to_array($chat->streamSendMessage('Hi'));

    expect($chat->history[1]->toArray()['parts'])
        ->toBe([
            ['text' => 'Thinking more.', 'thought' => true],
            ['text' => 'Answer.'],
        ]);
});

test('stream send message keeps function calls apart from text', function () {
    $client = mockStreamClient(method: Method::POST, endpoint: 'models/gemini-2.5-flash:streamGenerateContent', response: streamedChatResponse([
        [['text' => 'Let me check.']],
        [['functionCall' => ['name' => 'get_weather', 'args' => ['city' => 'Ankara']]]],
    ]));

    $chat = $client->generativeModel('models/gemini-2.5-flash')->startChat();
    iterator_to_array($chat->streamSendMessage('Weather in Ankara?'));

    expect($chat->history[1]->toArray()['parts'])
        ->toBe([
            ['text' => 'Let me check.'],
            ['functionCall' => ['name' => 'get_weather', 'args' => ['city' => 'Ankara']]],
        ]);
});
