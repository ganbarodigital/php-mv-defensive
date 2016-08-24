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
use GanbaroDigital\Defensive\V1\Checks\IsAnyOneOf;
use GanbaroDigital\Defensive\V1\Checks\ListableCheck;
use GanbaroDigital\Defensive\V1\Interfaces\Check;
use PHPUnit_Framework_TestCase;
use stdClass;
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

/**
 * @coversDefaultClass GanbaroDigital\Defensive\V1\Checks\IsAnyOneOf
 */
class IsAnyOneOfTest extends PHPUnit_Framework_TestCase
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

        $unit = new IsAnyOneOf([ new IsAnyOneOfTest_IsNull ]);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(IsAnyOneOf::class, $unit);
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

        $unit = new IsAnyOneOf([ new IsAnyOneOfTest_IsNull ]);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(Check::class, $unit);
    }

    /**
     * @covers ::inspect
     */
    public function testCanUseAsObject()
    {
        // ----------------------------------------------------------------
        // setup your test

        $checks = [
            new IsAnyOneOfTest_IsNull,
            new IsAnyOneOfTest_IsNumeric,
        ];

        $unit = new IsAnyOneOf($checks);

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = $unit->inspect(1.0);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($actualResult);
    }

    /**
     * @covers ::using
     * @covers ::inspect
     */
    public function testCanCallStatically()
    {
        // ----------------------------------------------------------------
        // setup your test

        $checks = [
            new IsAnyOneOfTest_IsNull,
            new IsAnyOneOfTest_IsNumeric,
        ];

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = IsAnyOneOf::using($checks)->inspect(1.0);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($actualResult);
    }

    /**
     * @covers ::__construct
     * @covers ::inspect
     * @dataProvider provideBadChecks
     * @expectedException InvalidArgumentException
     */
    public function testMustProvideAListOfChecks($checks)
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        IsAnyOneOf::using($checks)->inspect([]);
    }

    /**
     * @covers ::using
     * @covers ::__construct
     * @dataProvider provideInvalidChecks
     * @expectedException GanbaroDigital\Defensive\V1\Exceptions\BadCheck
     */
    public function testChecksListMustContainValidChecks($checks)
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        IsAnyOneOf::using($checks)->check([]);
    }

    /**
     * @covers ::using
     * @covers ::inspect
     */
    public function testWillMatchAnyCheckGiven()
    {
        // ----------------------------------------------------------------
        // setup your test

        // this group accepts null and numerics
        $checks = [
            new IsAnyOneOfTest_IsNull,
            new IsAnyOneOfTest_IsNumeric
        ];

        // ----------------------------------------------------------------
        // perform the change

        $actualResult1 = IsAnyOneOf::using($checks)->inspect(null);
        $actualResult2 = IsAnyOneOf::using($checks)->inspect(1.0);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($actualResult1);
        $this->assertTrue($actualResult2);
    }

    /**
     * @covers ::using
     * @covers ::inspect
     * @dataProvider provideGroup2NoMatches
     */
    public function test_returns_false_if_no_checks_pass($item)
    {
        // ----------------------------------------------------------------
        // setup your test

        // this group accepts null and strings
        $checks = [
            new IsAnyOneOfTest_IsNull,
            new IsAnyOneOfTest_IsString
        ];

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = IsAnyOneOf::using($checks)->inspect($item);

        // ----------------------------------------------------------------
        // test the results

        $this->assertFalse($actualResult);
    }

    /**
     * @covers ::using
     * @covers ::inspectList
     */
    public function test_can_apply_to_a_data_list()
    {
        // ----------------------------------------------------------------
        // setup your test

        $checks = [
            new IsAnyOneOfTest_IsString,
            new IsAnyOneOfTest_IsNumeric,
        ];

        $list = [
            "0",
            "1.0",
            "100"
        ];

        // ----------------------------------------------------------------
        // perform the change

        $actualResult = IsAnyOneOf::using($checks)->inspectList($list);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($actualResult);
    }

    /**
     * @covers ::using
     * @covers ::inspectList
     * @dataProvider provideNonLists
     * @expectedException InvalidArgumentException
     */
    public function test_throws_InvalidArgumentException_if_non_list_passed_to_toList($list)
    {
        // ----------------------------------------------------------------
        // setup your test

        $checks = [
            new IsAnyOneOfTest_IsString,
            new IsAnyOneOfTest_IsNumeric,
        ];

        // ----------------------------------------------------------------
        // perform the change

        IsAnyOneOf::using($checks)->inspectList($list);
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

    public function provideGroup2NoMatches()
    {
        return [
            [ false ],
            [ true ],
            [ STDIN ],
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

class IsAnyOneOfTest_IsNull implements Check
{
    public function inspect($item)
    {
        return is_null($item);
    }
}

class IsAnyOneOfTest_IsNumeric implements Check
{
    public function inspect($item)
    {
        return is_numeric($item);
    }
}

class IsAnyOneOfTest_IsString implements Check
{
    public function inspect($item)
    {
        return is_string($item);
    }
}
