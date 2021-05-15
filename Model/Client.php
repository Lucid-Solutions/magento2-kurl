<?php
/**
 * Copyright © Lucid Solutions. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidSolutions\Kurl\Model;

use LucidSolutions\Kurl\Api\Data\RequestInterface;
use LucidSolutions\Kurl\Api\Data\ResultInterface;
use LucidSolutions\Kurl\Api\Data\ResultInterfaceFactory;
use LucidSolutions\Kurl\Api\ClientInterface;
use InvalidArgumentException;
use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\Serialize\Serializer\Json;
use Throwable;

class Client implements ClientInterface
{
    private Curl $curl;

    private string $baseUrl;

    private ResultInterfaceFactory $resultFactory;

    private ClientLogger $clientLogger;

    private Json $json;

    /**
     * @param Curl $curl
     * @param ResultInterfaceFactory $resultFactory
     * @param ClientLogger $clientLogger
     * @param Json $json
     * @param string $baseUrl
     */
    public function __construct(
        Curl $curl,
        ResultInterfaceFactory $resultFactory,
        ClientLogger $clientLogger,
        Json $json,
        string $baseUrl
    ) {
        $this->curl = $curl;
        $this->resultFactory = $resultFactory;
        $this->clientLogger = $clientLogger;
        $this->json = $json;
        $this->baseUrl = rtrim('/', $baseUrl);
    }

    /**
     * @inheritDoc
     */
    public function execute(RequestInterface $request): ResultInterface
    {
        if (empty($this->baseUrl)) {
            throw new InvalidArgumentException('Invalid Kurl base url');
        }

        try {
            $result = $this->doRequest($request);
            $this->clientLogger->debug($request, $result);

            return $result;
        } catch (Throwable $e) {
            $this->clientLogger->debug($request, null);
            throw $e;
        }
    }

    /**
     * @param RequestInterface $request
     * @return ResultInterface
     */
    private function doRequest(RequestInterface $request): ResultInterface
    {
        $requestUrl = $this->baseUrl . $request->getEndpoint();
        if ($request->getMethod() === RequestInterface::METHOD_GET) {
            $this->curl->get($requestUrl);
        } else {
            $this->curl->post($requestUrl, $request->getBody());
        }
        if ($this->curl->getStatus() >= 400) {
            return $this->resultFactory->create(
                [
                    ResultInterface::KEY_STATUS => ResultInterface::STATUS_ERROR,
                    ResultInterface::KEY_BODY => $this->curl->getBody()
                ]
            );
        }

        $result = $this->curl->getBody();
        if (empty($result)) {
            return $this->resultFactory->create(
                [
                    ResultInterface::KEY_STATUS => ResultInterface::STATUS_ERROR,
                    ResultInterface::KEY_BODY => null
                ]
            );
        }

        $result = $this->json->unserialize($result);

        return $this->resultFactory->create($result);
    }
}
