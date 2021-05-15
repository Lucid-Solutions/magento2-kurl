<?php
/**
 * Copyright © Lucid Solutions. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace LucidSolutions\Kurl\Test\Unit\Model;

use LucidSolutions\Kurl\Model\Result;
use PHPUnit\Framework\TestCase;

class ResultTest extends TestCase
{
    public function testIsSuccessReturnsTrueWhenStatusIsSuccess(): void
    {
        $result = new Result('Success', []);

        $this->assertEquals(true, $result->isSuccess());
    }

    public function testIsSuccessReturnsFalseWhenStatusIsNotSuccess(): void
    {
        $result = new Result('Error', []);

        $this->assertEquals(false, $result->isSuccess());
    }
}
