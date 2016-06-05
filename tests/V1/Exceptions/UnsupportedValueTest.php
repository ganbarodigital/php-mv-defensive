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

use GanbaroDigital\Defensive\V1\Exceptions\UnsupportedValue;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveException;
use PHPUnit_Framework_TestCase;
use RuntimeException;
use stdClass;

/**
 * @coversDefaultClass GanbaroDigital\Defensive\V1\Exceptions\UnsupportedValue
 */
class UnsupportedValueTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $type = "NULL";

        // ----------------------------------------------------------------
        // perform the change

        $unit = new UnsupportedValue($type);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($unit instanceof UnsupportedValue);
    }

    /**
     * @covers ::__construct
     */
    public function testIsDefensiveException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $type = "NULL";

        // ----------------------------------------------------------------
        // perform the change

        $unit = new UnsupportedValue($type);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($unit instanceof DefensiveException);
    }

    /**
     * @covers ::__construct
     */
    public function testIsRuntimeException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $type = "NULL";

        // ----------------------------------------------------------------
        // perform the change

        $unit = new UnsupportedValue($type);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($unit instanceof RuntimeException);
    }

    /**
     * @covers ::__construct
     * @covers ::newFromVar
     */
    public function testAutomaticallyWorksOutWhoIsThrowingTheException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedCaller = [
            __CLASS__,
            __FUNCTION__,
        ];

        // ----------------------------------------------------------------
        // perform the change

        $unit = UnsupportedValue::newFromVar(null, 'value');

        // ----------------------------------------------------------------
        // test the results

        $actualData = $unit->getMessageData();
        $this->assertEquals($expectedCaller[0], $actualData['caller']->getClass());
        $this->assertEquals($expectedCaller[1], $actualData['caller']->getMethod());
    }

    /**
     * @covers ::__construct
     * @covers ::newFromVar
     */
    public function testAutomaticallyAddsThrowerDetailsIntoExceptionMessage()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedMessage = "ReflectionMethod->invokeArgs(): 'value' contains an unsupported value";
        $callerFilter = [ __CLASS__ ];

        // ----------------------------------------------------------------
        // perform the change

        $unit = UnsupportedValue::newFromVar(null, 'value', null, $callerFilter);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedMessage, $unit->getMessage());
    }
}
