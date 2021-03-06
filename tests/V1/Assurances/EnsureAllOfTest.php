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
 * @package   Defensive/V1/Assurances
 * @author    Stuart Herbert <stuherbert@ganbarodigital.com>
 * @copyright 2015-present Ganbaro Digital Ltd www.ganbarodigital.com
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link      http://ganbarodigital.github.io/php-mv-defensive
 */

namespace GanbaroDigitalTest\Defensive\V1\Assurances;

use GanbaroDigital\Defensive\V1\Exceptions\UnsupportedType;
use GanbaroDigital\Defensive\V1\Assurances\EnsureAllOf;
use GanbaroDigital\Defensive\V1\Assurances\InvokeableAssurance;
use GanbaroDigital\Defensive\V1\Assurances\ListableAssurance;
use GanbaroDigital\Defensive\V1\Interfaces\Assurance;
use PHPUnit_Framework_TestCase;
use stdClass;
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

/**
 * @coversDefaultClass GanbaroDigital\Defensive\V1\Assurances\EnsureAllOf
 */
class EnsureAllOfTest extends PHPUnit_Framework_TestCase
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

        $unit = new EnsureAllOf([new EnsureAllOfTest_EnsureString]);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(EnsureAllOf::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function test_is_Assurance()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new EnsureAllOf([new EnsureAllOfTest_EnsureString]);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(Assurance::class, $unit);
    }

    /**
     * @covers ::__invoke
     * @covers ::to
     */
    public function testCanUseAsObject()
    {
        // ----------------------------------------------------------------
        // setup your test

        $requirements = [
            new EnsureAllOfTest_EnsureString,
            new EnsureAllOfTest_EnsureNumeric,
        ];

        $unit = new EnsureAllOf($requirements);

        // ----------------------------------------------------------------
        // perform the change

        $unit("1.0", 'value');

        // ----------------------------------------------------------------
        // test the results
        //
        // if we get here, then no exception has been thrown :)
    }

    /**
     * @covers ::apply
     * @covers ::to
     */
    public function testCanCallStatically()
    {
        // ----------------------------------------------------------------
        // setup your test

        $requirements = [
            new EnsureAllOfTest_EnsureString,
            new EnsureAllOfTest_EnsureNumeric,
        ];

        // ----------------------------------------------------------------
        // perform the change

        EnsureAllOf::apply($requirements)->to("1.0", 'value');

        // ----------------------------------------------------------------
        // test the results
        //
        // if we get here, then no exception has been thrown :)
    }

    /**
     * @covers ::__construct
     * @dataProvider provideBadAssurances
     * @expectedException InvalidArgumentException
     */
    public function testMustProvideAListOfAssurances($requirements)
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        $unit = new EnsureAllOf($requirements);
    }

    /**
     * @covers ::__construct
     * @covers ::apply
     * @dataProvider provideInvalidAssurances
     * @expectedException GanbaroDigital\Defensive\V1\Exceptions\BadAssurance
     */
    public function testAssurancesListMustContainValidAssurances($requirements)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        EnsureAllOf::apply($requirements)->to('value');
    }

    /**
     * @covers ::apply
     * @covers ::to
     */
    public function testMustMatchAllAssurancesGiven()
    {
        // ----------------------------------------------------------------
        // setup your test

        $requirements = [
            new EnsureAllOfTest_EnsureString,
            new EnsureAllOfTest_EnsureNumeric,
        ];

        // ----------------------------------------------------------------
        // perform the change

        // if these do not match, an exception is thrown
        EnsureAllOf::apply($requirements)->to("1.0", 'value');
    }

    /**
     * @covers ::apply
     * @covers ::to
     * @dataProvider provideNoMatches
     * @expectedException RuntimeException
     */
    public function testThrowsExceptionIfNothingMatches($item)
    {
        // ----------------------------------------------------------------
        // setup your test

        $requirements = [
            new EnsureAllOfTest_EnsureString,
            new EnsureAllOfTest_EnsureNumeric,
        ];

        // ----------------------------------------------------------------
        // perform the change

        EnsureAllOf::apply($requirements)->to($item, "value");
    }

    /**
     * @covers ::apply
     * @covers ::toList
     */
    public function test_can_apply_to_a_data_list()
    {
        // ----------------------------------------------------------------
        // setup your test

        $assurances = [
            new EnsureAllOfTest_EnsureString,
            new EnsureAllOfTest_EnsureNumeric,
        ];

        $list = [
            "0",
            "1.0",
            "100"
        ];

        // ----------------------------------------------------------------
        // perform the change

        // if these do not match, an exception is thrown
        EnsureAllOf::apply($assurances)->toList($list, 'value');
    }

    /**
     * @covers ::apply
     * @covers ::toList
     * @dataProvider provideNonLists
     * @expectedException InvalidArgumentException
     */
    public function test_throws_InvalidArgumentException_if_non_list_passed_to_toList($list)
    {
        // ----------------------------------------------------------------
        // setup your test

        $assurances = [
            new EnsureAllOfTest_EnsureString,
            new EnsureAllOfTest_EnsureNumeric,
        ];

        // ----------------------------------------------------------------
        // perform the change

        EnsureAllOf::apply($assurances)->toList($list);
    }

    public function provideBadAssurances()
    {
        return [
            [ null ],
            [ false ],
            [ true ],
            [ 3.1415927 ],
            [ 100 ],
        ];
    }

    public function provideInvalidAssurances()
    {
        return [
            [ [1, 2, 3] ],
        ];
    }

    public function provideBadAssuranceData()
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

class EnsureAllOfTest_EnsureNumeric implements Assurance
{
    use InvokeableAssurance;
    use ListableAssurance;

    public function to($item, $fieldOrVarName = "value")
    {
        if (!is_numeric($item)) {
            throw new \RuntimeException("item is not numeric");
        }
    }
}

class EnsureAllOfTest_EnsureString implements Assurance
{
    use InvokeableAssurance;
    use ListableAssurance;

    public function to($item, $fieldOrVarName = "value")
    {
        if (!is_string($item)) {
            throw new \RuntimeException("item is not a string");
        }
    }
}

class EnsureAllOfTest_EnsureType implements Assurance
{
    use InvokeableAssurance;
    use ListableAssurance;

    public function to($item, $fieldOrVarName = "value")
    {
        if (gettype($item) !== $type){
            throw new \RuntimeException("item is not of type '{$type}'");
        }
    }
}
