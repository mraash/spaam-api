<?php

declare(strict_types=1);

namespace App\Integration\VKontakte\Part;

use App\Integration\VKontakte\Exception\VkApiException;
use App\Integration\VKontakte\Response\Output\ErrorOutput;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class AbstractPartApi
{
    public function __construct(
        protected HttpClientInterface $http,
        private readonly string $vkApiVersion,
    ) {
    }

    /**
     * @param array<string,mixed> $params
     */
    protected function request(string $apiMethod, string $accessToken = null, array $params = []): ResponseInterface
    {
        $query = [
            'v' => $this->vkApiVersion,
            ...$params,
        ];

        if ($accessToken !== null) {
            $query['access_token'] = $accessToken;
        }

        return $this->http->request('GET', "https://api.vk.com/method/$apiMethod", [
            'query' => $query,
        ]);
    }

    /**
     * If api returns an error response, the method throws VkApiException.
     *
     * @param array<string,mixed> $params
     */
    protected function requestSuccessful(
        string $apiMethod,
        string $accessToken = null,
        array $params = []
    ): ResponseInterface {
        $response = $this->request($apiMethod, $accessToken, $params);
        $responseData = $response->toArray();

        if (!$this->isResponseSuccessful($responseData)) {
            $error = ErrorOutput::fromBodyData($responseData);

            throw new VkApiException($error->code, $error->message);
        }

        return $response;
    }

    /**
     * @param ResponseInterface|mixed[] $response
     */
    protected function isResponseSuccessful(ResponseInterface|array $response): bool
    {
        $responseData = is_array($response) ? $response : $response->toArray();

        return isset($responseData['response']);
    }
}
