<?php

declare(strict_types = 1);

namespace Bot\Client;

use Exception;
use Bot\Enums\Messages;
use Bot\Components\Logger;
use GuzzleHttp\Psr7\Request;
use Bot\Models\Dto\Response;
use Bot\Exceptions\BotInitException;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\BadResponseException;

class Client implements HTTPClient
{
    public const SEND_MESSAGE = 'sendMessage';

    private GuzzleClient $client;

    /**
     * @throws BotInitException
     */
    public function __construct(public string $token, public string $basePath, public array $options = [])
    {
        if (empty($this->token) || empty($this->basePath)) {
            throw new BotInitException();
        }
        $this->client = new GuzzleClient([
            'base_uri' => 'https://' . $this->basePath,
            'timeout' => 2.0,
            'allow_redirects' => false,
            'verify' => false,
            'headers' => [
                'User-Agent' => $this->getUserAgent()
            ],
        ]);
    }

    public function send(string $method, int $chatID, Messages $message): void
    {
        $request = new Request('GET', $this->newBasePath($method));
        try {
            $response = $this->client->send($request, [
                'query' => [
                    'chat_id' => $chatID,
                    'text' => $message->message(),
                ]
            ]);
            if ($response->getStatusCode() !== 200) {
                throw new BadResponseException('status code != 200', $request, $response);
            }
            $this->registerResponse($response, $chatID);
        } catch (Exception $e) {
            Logger::getLogger(Logger::CONSUMER, Logger::CONSUMER)->error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }

    private function getUserAgent(): string
    {
        $uAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.89 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.125 Safari/537.36'
        ];
        return $uAgents[array_rand($uAgents)];
    }

    private function newBasePath(string $method): string
    {
        return '/bot' . $this->token . "/$method";
    }

    private function registerResponse(ResponseInterface $response, int $chatID): void
    {
        try {
            $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
            $responseModel = new Response(
                $data['ok'],
                $data['result']['message_id'],
                $chatID,
                $data['result']['chat']['first_name'],
                $data['result']['chat']['username']);
            Logger::getLogger(Logger::CONSUMER, Logger::CONSUMER)->info('success', [
                'response' => $responseModel
            ]);
        } catch (Exception $e) {
            Logger::getLogger(Logger::CONSUMER, Logger::CONSUMER)->error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
