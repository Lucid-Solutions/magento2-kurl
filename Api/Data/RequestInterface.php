<?php
/**
 * Copyright © Lucid Solutions. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace LucidSolutions\Kurl\Api\Data;

interface RequestInterface
{
    public const METHOD_POST = 'POST';
    public const METHOD_GET = 'GET';

    /**
     * Request body, represented by array.
     *
     * @return array
     */
    public function getBody(): array;

    /**
     * HTTP Method, e.g. POST. Please use constants defined in this interface (METHOD_*)
     *
     * @return string
     */
    public function getMethod(): string;

    /**
     * Endpoint of the request. Base url is added in the ClientInterface
     *
     * @return string
     */
    public function getEndpoint(): string;
}
