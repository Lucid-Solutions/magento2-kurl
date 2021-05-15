<?php

declare(strict_types=1);

namespace LucidSolutions\Kurl\Test\Unit\Model;

use LucidSolutions\Kurl\Api\Data\RequestInterface;
use LucidSolutions\Kurl\Api\Data\ResultInterface;
use LucidSolutions\Kurl\Model\ClientLogger;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ClientLoggerTest extends TestCase
{
    /**
     * @var MockObject|LoggerInterface
     */
    private $logger;

    private ClientLogger $clientLogger;

    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->clientLogger = new ClientLogger($this->logger);
    }

    public function testDebugLogsRequest(): void
    {
        $request = $this->createMock(RequestInterface::class);
        $request->method('getEndpoint')
            ->willReturn('/some/endpoint');
        $request->method('getMethod')
            ->willReturn('POST');
        $request->method('getBody')
            ->willReturn(['some' => 'content']);

        $this->logger->expects($this->once())
            ->method('debug')
            ->with(
                'Kurl Client Debug',
                [
                    'request' => [
                        'endpoint' => '/some/endpoint',
                        'method' => 'POST',
                        'body' => ['some' => 'content']
                    ]
                ]
            );

        $this->clientLogger->debug($request, null);
    }

    public function testDebugLogsRequestAndResult(): void
    {
        $request = $this->createMock(RequestInterface::class);
        $request->method('getEndpoint')
            ->willReturn('/some/endpoint');
        $request->method('getMethod')
            ->willReturn('POST');
        $request->method('getBody')
            ->willReturn(['some' => 'content']);

        $result = $this->createMock(ResultInterface::class);
        $result->method('isSuccess')
            ->willReturn(true);
        $result->method('getStatus')
            ->willReturn('Success');
        $result->method('getBody')
            ->willReturn(['response' => 'content']);

        $this->logger->expects($this->once())
            ->method('debug')
            ->with(
                'Kurl Client Debug',
                [
                    'request' => [
                        'endpoint' => '/some/endpoint',
                        'method' => 'POST',
                        'body' => ['some' => 'content']
                    ],
                    'result' => [
                        'isSuccess' => true,
                        'status' => 'Success',
                        'body' => ['response' => 'content']
                    ]
                ]
            );

        $this->clientLogger->debug($request, $result);
    }
}
