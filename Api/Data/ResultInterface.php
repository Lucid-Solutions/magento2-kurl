<?php
/**
 * Copyright © Lucid Solutions. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace LucidSolutions\Kurl\Api\Data;

interface ResultInterface
{
    public const KEY_STATUS = 'status';
    public const KEY_BODY = 'body';

    public const STATUS_SUCCESS = 'Success';
    public const STATUS_ERROR = 'Error';

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @return mixed
     */
    public function getBody();

    /**
     * @return bool
     */
    public function isSuccess(): bool;
}
