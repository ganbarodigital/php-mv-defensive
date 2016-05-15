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

use GanbaroDigital\Defensive\V1\Exceptions\BadRequirements;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveException;
use GanbaroDigital\ExceptionHelpers\V1\Callers\Values\CodeCaller;
use GanbaroDigital\HttpStatus\Interfaces\HttpStatusProvider;
use GanbaroDigital\HttpStatus\Interfaces\HttpRequestErrorException;
use GanbaroDigital\HttpStatus\StatusValues\RequestError\UnprocessableEntityStatus;
use PHPUnit_Framework_TestCase;
use RuntimeException;
use stdClass;

/**
 * @coversDefaultClass GanbaroDigital\Defensive\V1\Exceptions\BadRequirements
 */
class BadRequirementsTest extends PHPUnit_Framework_TestCase
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

        $unit = new BadRequirements($method);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadRequirements::class, $unit);
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

        $unit = new BadRequirements($method);

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

        $unit = new BadRequirements($method);

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

        $unit = new BadRequirements($method);

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

        $unit = new BadRequirements($method);
        $httpStatus = $unit->getHttpStatus();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(UnprocessableEntityStatus::class, $httpStatus);
    }

    /**
     * @covers ::newFromRequirementsList
     */
    public function testCanCreateFromBadRequirementsList()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = BadRequirements::newFromRequirementsList(true);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadRequirements::class, $unit);
    }

    /**
     * @covers ::newFromRequirementsList
     */
    public function test_newFromRequirementsList_states_that_list_must_contain_callables()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedMessage = "Bad requirements passed into GanbaroDigitalTest\Defensive\V1\Exceptions\BadRequirementsTest->test_newFromRequirementsList_states_that_list_must_contain_callables()@209 by ReflectionMethod->invokeArgs(); must be an array of callables";
        $expectedData = [
            'thrownBy' => new CodeCaller('GanbaroDigitalTest\Defensive\V1\Exceptions\BadRequirementsTest', 'test_newFromRequirementsList_states_that_list_must_contain_callables', '->', __FILE__, 209),
            'thrownByName' => 'GanbaroDigitalTest\Defensive\V1\Exceptions\BadRequirementsTest->test_newFromRequirementsList_states_that_list_must_contain_callables()@209',
            'caller' => new CodeCaller('ReflectionMethod', 'invokeArgs', '->', null, null),
            'callerName' => 'ReflectionMethod->invokeArgs()',
            'badRequirements' => true,
            'badRequirementsType' => 'boolean',
        ];

        // ----------------------------------------------------------------
        // perform the change

        // we have to pass in an empty filter here, because the default filter
        // filters out 'Exceptions', which is one of our namespaces
        $unit = BadRequirements::newFromRequirementsList(true, []);
        $this->assertInstanceOf(BadRequirements::class, $unit);

        $actualMessage = $unit->getMessage();
        $actualData = $unit->getMessageData();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedMessage, $actualMessage);
        $this->assertEquals($expectedData, $actualData);
    }

    /**
     * @covers ::newFromRequirementsList
     */
    public function test_newFromRequirementsList_will_provide_a_default_set_of_caller_filters()
    {
        // ----------------------------------------------------------------
        // setup your test

        // we only look for a small amount of data here, because filenames
        // and line numbers could easily change in the future
        $expectedThrownBy = new CodeCaller('ReflectionMethod', 'invokeArgs', '->', null, null);

        // ----------------------------------------------------------------
        // perform the change

        $unit = BadRequirements::newFromRequirementsList([]);
        $actualData = $unit->getMessageData();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedThrownBy, $actualData['thrownBy']);
    }

    /**
     * @covers ::newFromEmptyList
     */
    public function testCanCreateFromEmptyRequirementsList()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = BadRequirements::newFromEmptyList();
        $actualData = $unit->getMessageData();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadRequirements::class, $unit);
    }

    /**
     * @covers ::newFromEmptyList
     */
    public function test_newFromEmptyList_states_that_list_cannot_be_empty()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedMessage = "Bad requirements passed into GanbaroDigitalTest\Defensive\V1\Exceptions\BadRequirementsTest->test_newFromEmptyList_states_that_list_cannot_be_empty()@279 by ReflectionMethod->invokeArgs(); empty array provided";

        // ----------------------------------------------------------------
        // perform the change

        $unit = BadRequirements::newFromEmptyList([]);
        $actualMessage = $unit->getMessage();

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedMessage, $actualMessage);
    }
}
