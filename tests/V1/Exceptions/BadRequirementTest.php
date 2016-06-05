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
 * @package   Defensive/Exceptions
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-defensive
 */

namespace GanbaroDigitalTest\Defensive\V1\Exceptions;

use GanbaroDigital\Defensive\V1\Exceptions\BadRequirement;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveException;
use GanbaroDigital\ExceptionHelpers\V1\Callers\Values\CodeCaller;
use GanbaroDigital\HttpStatus\Interfaces\HttpStatusProvider;
use GanbaroDigital\HttpStatus\StatusValues\RequestError\UnprocessableEntityStatus;
use PHPUnit_Framework_TestCase;
use RuntimeException;
use stdClass;

/**
 * @coversDefaultClass GanbaroDigital\Defensive\V1\Exceptions\BadRequirement
 */
class BadRequirementTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $msg = __METHOD__;

        // ----------------------------------------------------------------
        // perform the change

        $unit = new BadRequirement($msg);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadRequirement::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function testIsDefensiveException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $msg = __METHOD__;

        // ----------------------------------------------------------------
        // perform the change

        $unit = new BadRequirement($msg);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(DefensiveException::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function testIsRuntimeException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $msg = __METHOD__;

        // ----------------------------------------------------------------
        // perform the change

        $obj = new BadRequirement($msg);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($obj instanceof RuntimeException);
    }

    /**
     * @covers ::__construct
     */
    public function testIsHttpStatusProvider()
    {
        // ----------------------------------------------------------------
        // setup your test

        $method = __METHOD__;

        // ----------------------------------------------------------------
        // perform the change

        $unit = new BadRequirement($method);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($unit instanceof HttpStatusProvider);
    }

    /**
     * @covers ::__construct
     */
    public function testMapsToUnprocessableEntity()
    {
        // ----------------------------------------------------------------
        // setup your test

        $method = __METHOD__;

        // ----------------------------------------------------------------
        // perform the change

        $unit = new BadRequirement($method);
        $httpStatus = $unit->getHttpStatus();

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($httpStatus instanceof UnprocessableEntityStatus);
    }

    /**
     * @covers ::newFromRequirement
     */
    public function testCanCreateFromBadRequirement()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedMessage = "Bad requirement passed into GanbaroDigitalTest\Defensive\V1\Exceptions\BadRequirementTest->testCanCreateFromBadRequirement()@189 by ReflectionMethod->invokeArgs(); must be instance of Requirement";
        $expectedData = [
            'thrownBy' => new CodeCaller('GanbaroDigitalTest\Defensive\V1\Exceptions\BadRequirementTest', 'testCanCreateFromBadRequirement', '->', __FILE__, 189),
            'thrownByName' => 'GanbaroDigitalTest\Defensive\V1\Exceptions\BadRequirementTest->testCanCreateFromBadRequirement()@189',
            'caller' => new CodeCaller('ReflectionMethod', 'invokeArgs', '->', null, null),
            'callerName' => 'ReflectionMethod->invokeArgs()',
            'badRequirement' => [],
            'badRequirementType' => 'array',
        ];

        // ----------------------------------------------------------------
        // perform the change

        // we have to pass in an empty filter here, because the default filter
        // filters out 'Exceptions', which is one of our namespaces
        $unit = BadRequirement::newFromRequirement([],[]);
        $this->assertInstanceOf(BadRequirement::class, $unit);

        $actualMessage = $unit->getMessage();
        $actualData = $unit->getMessageData();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedMessage, $actualMessage);
        $this->assertEquals($expectedData, $actualData);
    }

    /**
     * @covers ::newFromRequirement
     */
    public function test_newFromRequirement_will_provide_an_empty_set_of_caller_filters()
    {
        // ----------------------------------------------------------------
        // setup your test

        // we only look for a small amount of data here, because filenames
        // and line numbers could easily change in the future
        $expectedThrownBy = new CodeCaller(__CLASS__, __FUNCTION__, '->', __FILE__, __LINE__ + 5);

        // ----------------------------------------------------------------
        // perform the change

        $unit = BadRequirement::newFromRequirement(null);
        $this->assertInstanceOf(BadRequirement::class, $unit);

        $actualData = $unit->getMessageData();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedThrownBy, $actualData['thrownBy']);
    }
}
