<?php
/**
 * Copyright © Lucid Solutions. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace LucidSolutions\Kurl\Api;

use LucidSolutions\Kurl\Api\Data\RequestInterface;
use LucidSolutions\Kurl\Api\Data\ResultInterface;

interface ClientInterface
{
    /**
     * @param RequestInterface $request
     * @return ResultInterface
     */
    public function execute(RequestInterface $request): ResultInterface;
}
