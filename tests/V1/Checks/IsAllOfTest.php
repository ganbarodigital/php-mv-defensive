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
 * @package   Defensive/V1/Checks
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-defensive
 */

namespace GanbaroDigitalTest\Defensive\V1\Checks;

use GanbaroDigital\Defensive\V1\Exceptions\UnsupportedType;
use GanbaroDigital\Defensive\V1\Checks\IsAllOf;
use GanbaroDigital\Defensive\V1\Checks\ListableCheck;
use GanbaroDigital\Defensive\V1\Interfaces\Check;
use PHPUnit_Framework_TestCase;
use stdClass;
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

/**
 * @coversDefaultClass GanbaroDigital\Defensive\V1\Checks\IsAllOf
 */
class IsAllOfTest extends PHPUnit_Framework_TestCase
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

        $unit = new IsAllOf([new IsAllOfTest_IsString]);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(IsAllOf::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_Check()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new IsAllOf([new IsAllOfTest_IsString]);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(Check::class, $unit);
    }

    /**
     * @covers ::__construct
     * @covers ::inspect
     */
    public function testCanUseAsObject()
    {
        // ----------------------------------------------------------------
        // setup your test

        $checks = [
            new IsAllOfTest_IsString,
            new IsAllOfTest_IsNumeric,
        ];

        $unit = new IsAllOf($checks);

        // ----------------------------------------------------------------
        // perform the change

        $unit->inspect("1.0", 'value');

        // ----------------------------------------------------------------
        // test the results
        //
        // if we get here, then no exception has been thrown :)
    }

    /**
     * @covers ::__construct
     * @covers ::using
     * @covers ::inspect
     */
    public function testCanCallStatically()
    {
        // ----------------------------------------------------------------
        // setup your test

        $checks = [
            new IsAllOfTest_IsString,
            new IsAllOfTest_IsNumeric,
        ];

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = IsAllOf::using($checks)->inspect("1.0", 'value');

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($actualResult);
    }

    /**
     * @covers ::__construct
     * @dataProvider provideBadChecks
     * @expectedException InvalidArgumentException
     */
    public function testMustProvideAListOfChecks($checks)
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = new IsAllOf($checks);
    }

    /**
     * @covers ::__construct
     * @covers ::using
     * @covers ::inspect
     * @dataProvider provideInvalidChecks
     * @expectedException GanbaroDigital\Defensive\V1\Exceptions\BadCheck
     */
    public function testChecksListMustContainValidChecks($checks)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        IsAllOf::using($checks)->inspect('value');
    }

    /**
     * @covers ::__construct
     * @covers ::inspect
     * @dataProvider provideNoMatches
     */
    public function testReturnsFalseIfNothingMatches($item)
    {
        // ----------------------------------------------------------------
        // setup your test

        $checks = [
            new IsAllOfTest_IsString,
            new IsAllOfTest_IsNumeric,
        ];

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = IsAllOf::using($checks)->inspect($item);

        // ----------------------------------------------------------------
        // test the results

        $this->assertFalse($actualResult);
    }

    /**
     * @covers ::__construct
     * @covers ::using
     * @covers ::inspectList
     */
    public function test_can_apply_to_a_data_list()
    {
        // ----------------------------------------------------------------
        // setup your test

        $checks = [
            new IsAllOfTest_IsString,
            new IsAllOfTest_IsNumeric,
        ];

        $list = [
            "0",
            "1.0",
            "100"
        ];

        // ----------------------------------------------------------------
        // perform the change

        // if these do not match, an exception is thrown
        IsAllOf::using($checks)->inspectList($list);
    }

    /**
     * @covers ::__construct
     * @covers ::using
     * @covers ::inspectList
     * @dataProvider provideNonLists
     * @expectedException InvalidArgumentException
     */
    public function test_throws_InvalidArgumentException_if_non_list_passed_to_inspectList($list)
    {
        // ----------------------------------------------------------------
        // setup your test

        $checks = [
            new IsAllOfTest_IsString,
            new IsAllOfTest_IsNumeric,
        ];

        // ----------------------------------------------------------------
        // perform the change

        IsAllOf::using($checks)->inspectList($list);
    }

    public function provideBadChecks()
    {
        return [
            [ null ],
            [ false ],
            [ true ],
            [ 3.1415927 ],
            [ 100 ],
        ];
    }

    public function provideInvalidChecks()
    {
        return [
            [ [1, 2, 3] ],
        ];
    }

    public function provideBadCheckData()
    {
        return [
            [ null ],
            [ false ],
            [ true ],
            [ 3.1415927 ],
            [ 100 ],
            [ new stdClass ],
            [ "hello, world!" ],
        ];
    }

    public function provideNoMatches()
    {
        return [
            [ false ],
            [ true ],
            [ "hello, world!" ],
            [ new stdClass ]
        ];
    }

    public function provideNonLists()
    {
        return [
            [ null ],
            [ false ],
            [ true ],
            [ 3.1415927 ],
            [ 100 ],
            [ STDIN ],
            [ "hello, world!" ]
        ];
    }
}

class IsAllOfTest_IsNumeric implements Check
{
    use ListableCheck;

    public function inspect($item)
    {
        return is_numeric($item);
    }
}

class IsAllOfTest_IsString implements Check
{
    use ListableCheck;

    public function inspect($item)
    {
        return is_string($item);
    }
}

class IsAllOfTest_IsType implements Check
{
    use ListableCheck;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function inspect($item)
    {
        return (gettype($item) === $type);
    }
}
