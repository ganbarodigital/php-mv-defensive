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

namespace GanbaroDigitalTest\Defensive\Exceptions;

use GanbaroDigital\Defensive\V1\Exceptions\UnreachableCodeExecuted;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveException;
use PHPUnit_Framework_TestCase;
use RuntimeException;
use stdClass;
use GanbaroDigital\ExceptionHelpers\V1\BaseExceptions\ParameterisedException;
use GanbaroDigital\ExceptionHelpers\V1\Callers\Values\CodeCaller;
use GanbaroDigital\HttpStatus\Interfaces\HttpRuntimeErrorException;
use GanbaroDigital\HttpStatus\StatusValues\RuntimeError\UnexpectedErrorStatus;

/**
 * @coversDefaultClass GanbaroDigital\Defensive\V1\Exceptions\UnreachableCodeExecuted
 */
class UnreachableCodeExecutedTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new UnreachableCodeExecuted(__METHOD__);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($unit instanceof UnreachableCodeExecuted);
    }

    /**
     * @covers ::__construct
     */
    public function testIsDefensiveException()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new UnreachableCodeExecuted(__METHOD__);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(DefensiveException::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_ParameterisedException()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new UnreachableCodeExecuted(__METHOD__);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceof(ParameterisedException::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_HttpRuntimeErrorException()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new UnreachableCodeExecuted(__METHOD__);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceof(HttpRuntimeErrorException::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_maps_to_HTTP_500_UnexpectedError()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new UnreachableCodeExecuted(__METHOD__);

        // ----------------------------------------------------------------
        // perform the change

        $httpStatus = $unit->getHttpStatus();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceof(UnexpectedErrorStatus::class, $httpStatus);
    }

    /**
     * @covers ::__construct
     */
    public function testIsRuntimeException()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new UnreachableCodeExecuted(__METHOD__);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(RuntimeException::class, $unit);
    }

    /**
     * @covers ::newAlert
     */
    public function testCanRaiseNewAlert()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = UnreachableCodeExecuted::newAlert();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(UnreachableCodeExecuted::class, $unit);
    }

    /**
     * @covers ::newAlert
     */
    public function testNewAlertMessageIncludesCallerDetails()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedMessage = __CLASS__ . '->' . __FUNCTION__ . '()@209: unreachable code executed';

        // ----------------------------------------------------------------
        // perform the change

        $unit = UnreachableCodeExecuted::newAlert();
        $actualMessage = $unit->getMessage();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedMessage, $actualMessage);
    }

    /**
     * @covers ::newAlert
     */
    public function testNewAlertDataIncludesCallerDetails()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedData = [
            'thrownBy' => new CodeCaller(__CLASS__, __FUNCTION__, '->', __FILE__, 234),
            'thrownByName' => __CLASS__ . '->' . __FUNCTION__ . '()@234',
        ];

        // ----------------------------------------------------------------
        // perform the change

        $unit = UnreachableCodeExecuted::newAlert();
        $actualData = $unit->getMessageData();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedData, $actualData);
    }
}
