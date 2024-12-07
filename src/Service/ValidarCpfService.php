<?php

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class ValidarCpfService
{
    private HttpClientInterface $httpClient;
    private string $token;
    private LoggerInterface $logger;

    public function __construct(HttpClientInterface $httpClient, string $token, LoggerInterface $logger)
    {
        $this->httpClient = $httpClient;
        $this->token = $token;
        $this->logger = $logger;
    }

    public function execute(string $cpf): bool
    {
        if (!$this->validarCpfLocalmente($cpf)) {
            return false;
        }

        try {
            $response = $this->httpClient->request('GET', 'https://api.invertexto.com/v1/validator', [
                'query' => [
                    'value' => $cpf,
                    'type' => 'cpf',
                    'token' => $this->token,
                ],
            ]);

            return $response->toArray()['valid'] ?? false;

        } catch (TransportExceptionInterface | ClientExceptionInterface | ServerExceptionInterface $e) {
            $this->logger->error('Erro ao validar CPF na API externa', [
                'cpf' => $cpf,
                'exception' => $e->getMessage(),
            ]);

            return false;
        }
    }

    private function validarCpfLocalmente(string $cpf): bool
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);

        if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }

        return true;
    }
}
