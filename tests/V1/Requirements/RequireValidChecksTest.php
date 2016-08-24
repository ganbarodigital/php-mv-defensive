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
 * @package   Defensive/V1/Requirements
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-defensive
 */

namespace GanbaroDigitalTest\Defensive\V1\Requirements;
use stdClass;
use PHPUnit_Framework_TestCase;
use GanbaroDigital\Defensive\V1\Requirements\RequireValidChecks;
use GanbaroDigital\Defensive\V1\Interfaces\Check;
use GanbaroDigital\Defensive\V1\Interfaces\Requirement;
use GanbaroDigital\Defensive\V1\Interfaces\ListRequirement;

/**
 * @coversDefaultClass GanbaroDigital\Defensive\V1\Requirements\RequireValidChecks
 */
class RequireValidChecksTest extends PHPUnit_Framework_TestCase
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

        $unit = new RequireValidChecks;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(RequireValidChecks::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_ListRequirement()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new RequireValidChecks;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(ListRequirement::class, $unit);
    }

    /**
     * @covers ::__construct
     * @covers ::inspectList
     * @covers ::toList
     * @covers ::to
     */
    public function testCanUseAsObject()
    {
        // ----------------------------------------------------------------
        // setup your test

        $checks = [
            new RequireValidChecksTest_IsNumeric,
            new RequireValidChecksTest_IsString,
            new RequireValidChecksTest_IsType('string')
        ];

        // ----------------------------------------------------------------
        // perform the change

        $unit = new RequireValidChecks;
        $unit->inspectList($checks);

        // ----------------------------------------------------------------
        // test the results
        //
        // we use a simple assertion here so that this doesn't get flagged
        // as a 'useless' test

        $this->assertTrue(true);
    }

    /**
     * @covers ::apply
     * @covers ::toList
     * @covers ::to
     */
    public function testCanCallStatically()
    {
        // ----------------------------------------------------------------
        // setup your test

        $checks = [
            new RequireValidChecksTest_IsNumeric,
            new RequireValidChecksTest_IsString,
            new RequireValidChecksTest_IsType('string')
        ];

        // ----------------------------------------------------------------
        // perform the change

        RequireValidChecks::apply()->toList($checks);

        // ----------------------------------------------------------------
        // test the results
        //
        // we use a simple assertion here so that this doesn't get flagged
        // as a 'useless' test

        $this->assertTrue(true);
    }

    /**
     * @covers ::apply
     * @covers ::toList
     * @covers ::to
     * @dataProvider provideNonArraysToTest
     * @expectedException InvalidArgumentException
     */
    public function testMustProvideListOfChecks($checks)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        RequireValidChecks::apply()->toList($checks);

        // ----------------------------------------------------------------
        // test the results

    }

    /**
     * @covers ::apply
     * @covers ::toList
     * @covers ::to
     * @expectedException GanbaroDigital\Defensive\V1\Exceptions\BadCheck
     * @dataProvider provideNonArraysToTest
     */
    public function testListOfChecksCanContainOnlyChecks($check)
    {
        // ----------------------------------------------------------------
        // setup your test

        $checks = [ $check ];

        // ----------------------------------------------------------------
        // perform the change

        RequireValidChecks::apply()->toList($checks);

        // ----------------------------------------------------------------
        // test the results

    }

    /**
     * @covers ::apply
     * @covers ::toList
     * @covers ::to
     */
    public function test_can_apply_to_a_data_list()
    {
        // ----------------------------------------------------------------
        // setup your test

        $list = [
            new RequireValidChecksTest_IsNumeric(),
            new RequireValidChecksTest_IsString(),
        ];

        // ----------------------------------------------------------------
        // perform the change

        RequireValidChecks::apply()->toList($list);

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::apply
     * @covers ::toList
     * @covers ::to
     * @dataProvider provideNonListsToTest
     * @expectedException InvalidArgumentException
     */
    public function test_throws_InvalidArgumentException_if_non_list_passed_to_toList($list)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        RequireValidChecks::apply()->toList($list);
    }

    public function provideNonArraysToTest()
    {
        return [
            [ null ],
            [ true ],
            [ false ],
            [ function() {} ],
            [ 0.0 ],
            [ 3.1415927 ],
            [ 0 ],
            [ 100 ],
            [ STDIN ],
            [ "hello, world!" ],
        ];
    }

    public function provideNonListsToTest()
    {
        return [
            [ null ],
            [ true ],
            [ false ],
            [ function() {} ],
            [ 0.0 ],
            [ 3.1415927 ],
            [ 0 ],
            [ 100 ],
            [ STDIN ],
            [ "hello, world!" ],
        ];
    }
}

class RequireValidChecksTest_IsNumeric implements Check
{
    public function inspect($item)
    {
        return is_numeric($item);
    }
}

class RequireValidChecksTest_IsString implements Check
{
    public function inspect($item)
    {
        return is_string($item);
    }
}

class RequireValidChecksTest_IsType implements Check
{
    public function __construct($type)
    {
        $this->type = $type;
    }

    public function inspect($item)
    {
        return (gettype($item) === $this->type);
    }
}
