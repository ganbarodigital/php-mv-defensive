<?php

/**
 * Copyright (c) 2015-present Ganbaro Digital Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the names of the copyright holders nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @category  Libraries
 * @package   Defensive/V1/Exceptions
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-defensive
 */

namespace GanbaroDigitalTest\Defensive\V1\Exceptions;

use GanbaroDigital\Defensive\V1\Exceptions\ContractFailed;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveException;
use GanbaroDigital\ExceptionHelpers\V1\BaseExceptions\ParameterisedException;
use GanbaroDigital\HttpStatus\Interfaces\HttpRuntimeErrorException;
use GanbaroDigital\HttpStatus\StatusValues\RuntimeError\UnexpectedErrorStatus;
use PHPUnit_Framework_TestCase;
use RuntimeException;
use stdClass;

/**
 * @coversDefaultClass GanbaroDigital\Defensive\V1\Exceptions\ContractFailed
 */
class ContractFailedTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $reason = "must be > 100";

        // ----------------------------------------------------------------
        // perform the change

        $unit = new ContractFailed($reason);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($unit instanceof ContractFailed);
    }

    /**
     * @covers ::__construct
     */
    public function testIsDefensiveException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $reason = "must be > 100";

        // ----------------------------------------------------------------
        // perform the change

        $unit = new ContractFailed($reason);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($unit instanceof DefensiveException);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_ParameterisedException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $value = 100;
        $reason = "must be > 100";

        // ----------------------------------------------------------------
        // perform the change

        $unit = new ContractFailed($value, $reason);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($unit instanceof ParameterisedException);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_HttpRuntimeErrorException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $value = 100;
        $reason = "must be > 100";

        // ----------------------------------------------------------------
        // perform the change

        $unit = new ContractFailed($value, $reason);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($unit instanceof HttpRuntimeErrorException);
    }

    /**
     * @covers ::__construct
     */
    public function test_maps_to_HTTP_500_UnexpectedError()
    {
        // ----------------------------------------------------------------
        // setup your test

        $value = 100;
        $reason = "must be > 100";

        // ----------------------------------------------------------------
        // perform the change

        $unit = new ContractFailed($value, $reason);

        // ----------------------------------------------------------------
        // test the results

        $httpStatus = $unit->getHttpStatus();
        $this->assertInstanceOf(UnexpectedErrorStatus::class, $httpStatus);
    }

    /**
     * @covers ::__construct
     */
    public function testIsRuntimeException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $value = 100;
        $reason = "must be > 100";

        // ----------------------------------------------------------------
        // perform the change

        $unit = new ContractFailed($value, $reason);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($unit instanceof RuntimeException);
    }

    /**
     * @covers ::newFromBadValue
     */
    public function testCanCreateFromBadValue()
    {
        // ----------------------------------------------------------------
        // setup your test

        $value = 100;
        $reason = "must be > 100";

        // ----------------------------------------------------------------
        // perform the change

        $unit = ContractFailed::newFromBadValue($value, $reason);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(ContractFailed::class, $unit);
    }
}
