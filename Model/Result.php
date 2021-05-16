<?php
/**
 * Copyright © Lucid Solutions. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidSolutions\Kurl\Model;

use LucidSolutions\Kurl\Api\Data\ResultInterface;

class Result implements ResultInterface
{
    private string $status;

    /**
     * @var mixed
     */
    private $body;

    /**
     * @param string $status
     * @param mixed $body
     */
    public function __construct(string $status, $body)
    {
        $this->status = $status;
        $this->body = $body;
    }

    /**
     * @inheritDoc
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @inheritDoc
     */
    public function isSuccess(): bool
    {
        return $this->status === self::STATUS_SUCCESS;
    }
}
