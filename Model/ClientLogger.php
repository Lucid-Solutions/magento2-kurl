<?php
/**
 * Copyright © Lucid Solutions. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidSolutions\Kurl\Model;

use LucidSolutions\Kurl\Api\Data\RequestInterface;
use LucidSolutions\Kurl\Api\Data\ResultInterface;
use Psr\Log\LoggerInterface;

class ClientLogger
{
    private LoggerInterface $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    /**
     * @param RequestInterface $request
     * @param ResultInterface|null $result
     */
    public function debug(RequestInterface $request, ?ResultInterface $result): void
    {
        $loggerContext = [
            'request' => [
                'endpoint' => $request->getEndpoint(),
                'method' => $request->getMethod(),
                'body' => $request->getBody(),
            ],
        ];
        if ($result) {
            $loggerContext['result'] = [
                'isSuccess' => $result->isSuccess(),
                'status' => $result->getStatus(),
                'body' => $result->getBody(),
            ];
        }

        $this->logger->debug(
            'Kurl Client Debug',
            $loggerContext
        );
    }
}
