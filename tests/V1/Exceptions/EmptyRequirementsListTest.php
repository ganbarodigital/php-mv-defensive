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

use GanbaroDigital\Defensive\V1\Exceptions\EmptyRequirementsList;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveException;
use GanbaroDigital\ExceptionHelpers\V1\Callers\Values\CodeCaller;
use GanbaroDigital\HttpStatus\Interfaces\HttpStatusProvider;
use GanbaroDigital\HttpStatus\Interfaces\HttpRequestErrorException;
use GanbaroDigital\HttpStatus\StatusValues\RequestError\UnprocessableEntityStatus;
use PHPUnit_Framework_TestCase;
use RuntimeException;
use stdClass;

/**
 * @coversDefaultClass GanbaroDigital\Defensive\V1\Exceptions\EmptyRequirementsList
 */
class EmptyRequirementsListTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     */
    public function testCanInstantiate()
    {
        // ----------------------------------------------------------------
        // setup your test

        $method = __METHOD__;

        // ----------------------------------------------------------------
        // perform the change

        $unit = new EmptyRequirementsList($method);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(EmptyRequirementsList::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_DefensiveException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $method = __METHOD__;

        // ----------------------------------------------------------------
        // perform the change

        $unit = new EmptyRequirementsList($method);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(DefensiveException::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_RuntimeException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $method = __METHOD__;

        // ----------------------------------------------------------------
        // perform the change

        $unit = new EmptyRequirementsList($method);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(RuntimeException::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_HttpRequestErrorException()
    {
        // ----------------------------------------------------------------
        // setup your test

        $method = __METHOD__;

        // ----------------------------------------------------------------
        // perform the change

        $unit = new EmptyRequirementsList($method);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(HttpRequestErrorException::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_maps_to_HTTP_422_UnprocessableEntity()
    {
        // ----------------------------------------------------------------
        // setup your test

        $method = __METHOD__;

        // ----------------------------------------------------------------
        // perform the change

        $unit = new EmptyRequirementsList($method);
        $httpStatus = $unit->getHttpStatus();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(UnprocessableEntityStatus::class, $httpStatus);
    }

    /**
     * @covers ::newFromVar
     */
    public function testCanCreateFromEmptyRequirementsListList()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = EmptyRequirementsList::newFromVar(true, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(EmptyRequirementsList::class, $unit);
    }

    /**
     * @covers ::newFromVar
     */
    public function test_exception_states_that_list_must_not_be_empty()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedMessage = __CLASS__ . '->' . __FUNCTION__ . "()@206: array cannot be empty";
        $expectedData = [
            'thrownBy' => new CodeCaller(__CLASS__, __FUNCTION__, '->', __FILE__, 206),
            'thrownByName' => __CLASS__ . '->' . __FUNCTION__ . "()@206",
            'dataType' => "boolean<true>",
            'fieldOrVarName' => '$data',
            'fieldOrVar' => true,
        ];

        // ----------------------------------------------------------------
        // perform the change

        $unit = EmptyRequirementsList::newFromVar(true, '$data');
        $this->assertInstanceOf(EmptyRequirementsList::class, $unit);

        $actualMessage = $unit->getMessage();
        $actualData = $unit->getMessageData();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedMessage, $actualMessage);
        $this->assertEquals($expectedData, $actualData);
    }
}
