<p align="center">
    <img src="https://raw.githubusercontent.com/google-gemini-php/client/main/art/example.png" width="600" alt="Google Gemini PHP">
    <p align="center">
        <a href="https://packagist.org/packages/google-gemini-php/client"><img alt="Latest Version" src="https://img.shields.io/packagist/v/google-gemini-php/client"></a>
        <a href="https://packagist.org/packages/google-gemini-php/client"><img alt="License" src="https://img.shields.io/github/license/google-gemini-php/client"></a>
    </p>
</p>

------

**Gemini PHP** is a community-maintained PHP API client that allows you to interact with the Gemini AI API.

- Fatih AYDIN [github.com/aydinfatih](https://github.com/aydinfatih)

## Table of Contents
- [Prerequisites](#prerequisites)
- [Setup](#setup)
  - [Installation](#installation)
  - [Setup your API key](#setup-your-api-key)
- [Usage](#usage)
    - [Chat Resource](#chat-resource)
      - [Text-only Input](#text-only-input)
      - [Text-and-image Input](#text-and-image-input)
      - [Multi-turn Conversations (Chat)](#multi-turn-conversations-chat)
      - [Stream Generate Content](#stream-generate-content)
      - [Count tokens](#count-tokens)
      - [Configuration](#configuration)
    - [Embedding Resource](#embedding-resource)
    - [Models](#models)
      - [List Models](#list-models)
      - [Get Model](#get-model)
- [Troubleshooting](#troubleshooting)
- [Testing](#testing)


## Prerequisites
To complete this quickstart, make sure that your development environment meets the following requirements:

- Requires [PHP 8.1+](https://php.net/releases/)


## Setup

### Installation

First, install Gemini via the [Composer](https://getcomposer.org/) package manager:

```bash
composer require google-gemini-php/client
```

If you want to use beta features you should install beta branch:

```bash
composer require google-gemini-php/client:1.0.4-beta
```

For beta documentation: https://github.com/google-gemini-php/client/tree/beta

Ensure that the `php-http/discovery` composer plugin is allowed to run or install a client manually if your project does not already have a PSR-18 client integrated.
```bash
composer require guzzlehttp/guzzle
```

### Setup your API key
To use the Gemini API, you'll need an API key. If you don't already have one, create a key in Google AI Studio.

[Get an API key](https://makersuite.google.com/app/apikey)

## Usage

Interact with Gemini's API:

```php
$yourApiKey = getenv('YOUR_API_KEY');
$client = Gemini::client($yourApiKey);

$result = $client->geminiPro()->generateContent('Hello');
$result->text(); // Hello! How can I assist you today?

// Custom Model
$result = $client->geminiPro()->generativeModel(model: 'models/gemini-1.5-flash-001');
$result->text(); // Hello! How can I assist you today?


// Enum usage
$result = $client->geminiPro()->generativeModel(model: ModelType::GEMINI_FLASH);
$result->text(); // Hello! How can I assist you today?


// Enum method usage
$result = $client->geminiPro()->generativeModel(
    model: ModelType::generateGeminiModel(
      variation: ModelVariation::FLASH,
      generation: 1.5,
      version: "002"
    ), // models/gemini-1.5-flash-002
);
$result->text(); // Hello! How can I assist you today?

```

If necessary, it is possible to configure and create a separate client.

```php
$yourApiKey = getenv('YOUR_API_KEY');

$client = Gemini::factory()
 ->withApiKey($yourApiKey)
 ->withBaseUrl('https://generativelanguage.example.com/v1') // default: https://generativelanguage.googleapis.com/v1/
 ->withHttpHeader('X-My-Header', 'foo')
 ->withQueryParam('my-param', 'bar')
 ->withHttpClient(new \GuzzleHttp\Client([]))  // default: HTTP client found using PSR-18 HTTP Client Discovery
 ->withStreamHandler(fn(RequestInterface $request): ResponseInterface => $client->send($request, [
   'stream' => true // Allows to provide a custom stream handler for the http client.
 ]))
 ->make();
```


### Chat Resource

#### Text-only Input
Generate a response from the model given an input message. If the input contains only text, use the `gemini-pro` model.

```php
$yourApiKey = getenv('YOUR_API_KEY');
$client = Gemini::client($yourApiKey);

$result = $client->geminiPro()->generateContent('Hello');

$result->text(); // Hello! How can I assist you today?
```

#### Text-and-image Input
If the input contains both text and image, use the `gemini-pro-vision` model. 

```php

$result = $client
 ->geminiFlash()
 ->generateContent([
  'What is this picture?',
  new Blob(
   mimeType: MimeType::IMAGE_JPEG,
   data: base64_encode(
    file_get_contents('https://storage.googleapis.com/generativeai-downloads/images/scones.jpg')
   )
  )
 ]);
 
$result->text(); //  The picture shows a table with a white tablecloth. On the table are two cups of coffee, a bowl of blueberries, a silver spoon, and some flowers. There are also some blueberry scones on the table.
```
#### Multi-turn Conversations (Chat)
Using Gemini, you can build freeform conversations across multiple turns.

```php
$chat = $client
 ->geminiPro()
 ->startChat(history: [
   Content::parse(part: 'The stories you write about what I have to say should be one line. Is that clear?'),
   Content::parse(part: 'Yes, I understand. The stories I write about your input should be one line long.', role: Role::MODEL)
 ]);

$response = $chat->sendMessage('Create a story set in a quiet village in 1600s France');
echo $response->text(); // Amidst rolling hills and winding cobblestone streets, the tranquil village of Beausoleil whispered tales of love, intrigue, and the magic of everyday life in 17th century France.

$response = $chat->sendMessage('Rewrite the same story in 1600s England');
echo $response->text(); // In the heart of England's lush countryside, amidst emerald fields and thatched-roof cottages, the village of Willowbrook unfolded a tapestry of love, mystery, and the enchantment of ordinary days in the 17th century.

```
>The `gemini-pro-vision` model (for text-and-image input) is not yet optimized for multi-turn conversations. Make sure to use gemini-pro and text-only input for chat use cases.

#### Stream Generate Content
By default, the model returns a response after completing the entire generation process. You can achieve faster interactions by not waiting for the entire result, and instead use streaming to handle partial results.

```php
$stream = $client
 ->geminiPro()
 ->streamGenerateContent('Write long a story about a magic backpack.');

foreach ($stream as $response) {
 echo $response->text();
}
```

#### Count tokens
When using long prompts, it might be useful to count tokens before sending any content to the model.

```php
$response = $client
 ->geminiPro()
 ->countTokens('Write a story about a magic backpack.');

echo $response->totalTokens; // 9
```

#### Configuration
Every prompt you send to the model includes parameter values that control how the model generates a response. The model can generate different results for different parameter values. Learn more about [model parameters](https://ai.google.dev/docs/concepts#model_parameters).

Also, you can use safety settings to adjust the likelihood of getting responses that may be considered harmful. By default, safety settings block content with medium and/or high probability of being unsafe content across all dimensions. Learn more about [safety settings](https://ai.google.dev/docs/concepts#safety_setting).


```php
use Gemini\Data\GenerationConfig;
use Gemini\Enums\HarmBlockThreshold;
use Gemini\Data\SafetySetting;
use Gemini\Enums\HarmCategory;

$safetySettingDangerousContent = new SafetySetting(
    category: HarmCategory::HARM_CATEGORY_DANGEROUS_CONTENT,
    threshold: HarmBlockThreshold::BLOCK_ONLY_HIGH
);

$safetySettingHateSpeech = new SafetySetting(
    category: HarmCategory::HARM_CATEGORY_HATE_SPEECH,
    threshold: HarmBlockThreshold::BLOCK_ONLY_HIGH
);

$generationConfig = new GenerationConfig(
    stopSequences: [
        'Title',
    ],
    maxOutputTokens: 800,
    temperature: 1,
    topP: 0.8,
    topK: 10
);

$generativeModel = $client
 ->geminiPro()
 ->withSafetySetting($safetySettingDangerousContent)
 ->withSafetySetting($safetySettingHateSpeech)
 ->withGenerationConfig($generationConfig)
 ->generateContent("Write a story about a magic backpack.");
```

### Embedding Resource
Embedding is a technique used to represent information as a list of floating point numbers in an array. With Gemini, you can represent text (words, sentences, and blocks of text) in a vectorized form, making it easier to compare and contrast embeddings. For example, two texts that share a similar subject matter or sentiment should have similar embeddings, which can be identified through mathematical comparison techniques such as cosine similarity.

Use the `embedding-001` model with either `embedContents` or `batchEmbedContents`:

```php
$response = $client
 ->embeddingModel()
 ->embedContent("Write a story about a magic backpack.");

print_r($response->embedding->values);
//[
//    [0] => 0.008624583
//    [1] => -0.030451821
//    [2] => -0.042496547
//    [3] => -0.029230341
//    [4] => 0.05486475
//    [5] => 0.006694871
//    [6] => 0.004025645
//    [7] => -0.007294857
//    [8] => 0.0057651913
//    ...
//]
```

```php
$response = $client
 ->embeddingModel()
 ->batchEmbedContents("Bu bir testtir", "Deneme123");

print_r($response->embeddings);
// [
// [0] => Gemini\Data\ContentEmbedding Object
// (
//     [values] => Array
//         (
//         [0] => 0.035855837
//         [1] => -0.049537655
//         [2] => -0.06834927
//         [3] => -0.010445258
//         [4] => 0.044641383
//         [5] => 0.031156342
//         [6] => -0.007810312
//         [7] => -0.0106866965
//         ...
//         ),
// ),
// [1] => Gemini\Data\ContentEmbedding Object
// (
//     [values] => Array
//         (
//         [0] => 0.035855837
//         [1] => -0.049537655
//         [2] => -0.06834927
//         [3] => -0.010445258
//         [4] => 0.044641383
//         [5] => 0.031156342
//         [6] => -0.007810312
//         [7] => -0.0106866965
//         ...
//         ),
// ),
// ]
```

### Models

#### List Models
Use list models to see the available Gemini models:

- **pageSize (optional)**:
  The maximum number of Models to return (per page). <br>
  If unspecified, 50 models will be returned per page. This method returns at most 1000 models per page, even if you pass a larger pageSize.


- **nextPageToken (optional)**:
    A page token, received from a previous models.list call. <br>
    Provide the pageToken returned by one request as an argument to the next request to retrieve the next page.
    When paginating, all other parameters provided to models.list must match the call that provided the page token.

```php
$response = $client->models()->list(pageSize: 3, nextPageToken: 'ChFtb2RlbHMvZ2VtaW5pLXBybw==');

$response->models;
//[
//    [0] => Gemini\Data\Model Object
//        (
//            [name] => models/gemini-pro
//            [version] => 001
//            [displayName] => Gemini Pro
//            [description] => The best model for scaling across a wide range of tasks
//            ...
//        )
//    [1] => Gemini\Data\Model Object
//        (
//            [name] => models/gemini-pro-vision
//            [version] => 001
//            [displayName] => Gemini Pro Vision
//            [description] => The best image understanding model to handle a broad range of applications
//            ...
//        )
//    [2] => Gemini\Data\Model Object
//        (
//            [name] => models/embedding-001
//            [version] => 001
//            [displayName] => Embedding 001
//            [description] => Obtain a distributed representation of a text.
//            ...
//        )
//]
```
```php
$response->nextPageToken // Chltb2RlbHMvZ2VtaW5pLTEuMC1wcm8tMDAx
```

#### Get Model
Get information about a model, such as version, display name, input token limit, etc.
```php

$response = $client->models()->retrieve(ModelType::GEMINI_PRO);

$response->model;
//Gemini\Data\Model Object
//(
//    [name] => models/gemini-pro
//    [version] => 001
//    [displayName] => Gemini Pro
//    [description] => The best model for scaling across a wide range of tasks
//    ...
//)
```

## Troubleshooting

### Timeout

You may run into a timeout when sending requests to the API. The default timeout depends on the HTTP client used.

You can increase the timeout by configuring the HTTP client and passing in to the factory.

This example illustrates how to increase the timeout using Guzzle.
```php
Gemini::factory()
    ->withApiKey($apiKey)
    ->withHttpClient(new \GuzzleHttp\Client(['timeout' => $timeout]))
    ->make();
```

## Testing

The package provides a fake implementation of the `Gemini\Client` class that allows you to fake the API responses.

To test your code ensure you swap the `Gemini\Client` class with the `Gemini\Testing\ClientFake` class in your test case.

The fake responses are returned in the order they are provided while creating the fake client.

All responses are having a `fake()` method that allows you to easily create a response object by only providing the parameters relevant for your test case.

```php
use Gemini\Testing\ClientFake;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;

$client = new ClientFake([
  GenerateContentResponse::fake([
    'candidates' => [
      [
        'content' => [
          'parts' => [
            [
              'text' => 'success',
            ],
          ],
        ],
      ],
    ],
  ]),
]);

$result = $fake->geminiPro()->generateContent('test');

expect($result->text())->toBe('success');
```

In case of a streamed response you can optionally provide a resource holding the fake response data.

```php
use Gemini\Testing\ClientFake;
use Gemini\Responses\GenerativeModel\GenerateContentResponse;

$client = new ClientFake([
    GenerateContentResponse::fakeStream(),
]);

$result = $client->geminiPro()->streamGenerateContent('Hello');

expect($response->getIterator()->current())
    ->text()->toBe('In the bustling city of Aethelwood, where the cobblestone streets whispered');
```

After the requests have been sent there are various methods to ensure that the expected requests were sent:

```php
// assert list models request was sent
$fake->models()->assertSent(callback: function ($method) {
    return $method === 'list';
});
// or
$fake->assertSent(resource: Models::class, callback: function ($method) {
    return $method === 'list';
});

$fake->geminiPro()->assertSent(function (string $method, array $parameters) {
    return $method === 'generateContent' &&
        $parameters[0] === 'Hello';
});
// or
$fake->assertSent(resource: GenerativeModel::class, model: ModelType::GEMINI_PRO, callback: function (string $method, array $parameters) {
    return $method === 'generateContent' &&
        $parameters[0] === 'Hello';
});


// assert 2 generative model requests were sent
$client->assertSent(resource: GenerativeModel::class, model: ModelType::GEMINI_PRO, callback: 2);
// or
$client->geminiPro()->assertSent(2);

// assert no generative model requests were sent
$client->assertNotSent(resource: GenerativeModel::class, model: ModelType::GEMINI_PRO);
// or
$client->geminiPro()->assertNotSent();

// assert no requests were sent
$client->assertNothingSent();
```

To write tests expecting the API request to fail you can provide a `Throwable` object as the response.

```php
$client = new ClientFake([
    new ErrorException([
        'message' => 'The model `gemini-basic` does not exist',
        'status' => 'INVALID_ARGUMENT',
        'code' => 400,
    ]),
]);

// the `ErrorException` will be thrown
$client->geminiPro()->generateContent('test');
```