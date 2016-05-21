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
use PHPUnit_Framework_TestCase;
use GanbaroDigital\Defensive\V1\Requirements\RequireValidRequirements;
use GanbaroDigital\Defensive\V1\Interfaces\Requirement;
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

/**
 * @coversDefaultClass GanbaroDigital\Defensive\V1\Requirements\RequireValidRequirements
 */
class RequireValidRequirementsTest extends PHPUnit_Framework_TestCase
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

        $unit = new RequireValidRequirements;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(RequireValidRequirements::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function testIsRequirement()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new RequireValidRequirements;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(Requirement::class, $unit);
    }

    /**
     * @covers ::__construct
     * @covers ::__invoke
     * @covers ::to
     */
    public function testCanUseAsObject()
    {
        // ----------------------------------------------------------------
        // setup your test

        $requirements = [
            new RequireValidRequirementsTest_RequireNumeric,
            new RequireValidRequirementsTest_RequireString,
            new RequireValidRequirementsTest_RequireType
        ];

        // ----------------------------------------------------------------
        // perform the change

        $unit = new RequireValidRequirements;
        $unit($requirements);

        // ----------------------------------------------------------------
        // test the results
        //
        // we use a simple assertion here so that this doesn't get flagged
        // as a 'useless' test

        $this->assertTrue(true);
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
            new RequireValidRequirementsTest_RequireNumeric,
            new RequireValidRequirementsTest_RequireString,
            new RequireValidRequirementsTest_RequireType
        ];

        // ----------------------------------------------------------------
        // perform the change

        RequireValidRequirements::apply()->to($requirements);

        // ----------------------------------------------------------------
        // test the results
        //
        // we use a simple assertion here so that this doesn't get flagged
        // as a 'useless' test

        $this->assertTrue(true);
    }

    /**
     * @covers ::apply
     * @covers ::to
     * @dataProvider provideNonArraysToTest
     * @expectedException GanbaroDigital\Defensive\V1\Exceptions\BadRequirements
     */
    public function testMustProvideListOfRequirements($requirements)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        RequireValidRequirements::apply()->to($requirements);

        // ----------------------------------------------------------------
        // test the results

    }

    /**
     * @covers ::apply
     * @covers ::to
     * @expectedException GanbaroDigital\Defensive\V1\Exceptions\BadRequirements
     */
    public function testListOfRequirementsCannotBeEmpty()
    {
        // ----------------------------------------------------------------
        // setup your test

        $requirements = [];

        // ----------------------------------------------------------------
        // perform the change

        RequireValidRequirements::apply()->to($requirements);

        // ----------------------------------------------------------------
        // test the results

    }

    /**
     * @covers ::apply
     * @covers ::to
     * @expectedException GanbaroDigital\Defensive\V1\Exceptions\BadRequirement
     * @dataProvider provideNonArraysToTest
     */
    public function testListOfRequirementsCanContainOnlyRequirements($requirement)
    {
        // ----------------------------------------------------------------
        // setup your test

        $requirements = [ $requirement ];

        // ----------------------------------------------------------------
        // perform the change

        RequireValidRequirements::apply()->to($requirements);

        // ----------------------------------------------------------------
        // test the results

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
            [ new \stdClass ],
            [ STDIN ],
            [ "hello, world!" ],
        ];
    }
}

class RequireValidRequirementsTest_RequireNumeric implements Requirement
{
    public function __invoke($item, $fieldOrVarName = "value", FactoryList $exceptions = null)
    {
        return $this->to($item, $fieldOrVarName, $exceptions);
    }

    public function to($item, $fieldOrVarName = "value", FactoryList $exceptions = null)
    {
        if (!is_numeric($item)) {
            throw new \RuntimeException("item is not numeric");
        }
    }
}

class RequireValidRequirementsTest_RequireString implements Requirement
{
    public function __invoke($item, $fieldOrVarName = "value", FactoryList $exceptions = null)
    {
        return $this->to($item, $fieldOrVarName, $exceptions);
    }

    public function to($item, $fieldOrVarName = "value", FactoryList $exceptions = null)
    {
        if (!is_string($item)) {
            throw new \RuntimeException("item is not a string");
        }
    }
}

class RequireValidRequirementsTest_RequireType implements Requirement
{
    public function __invoke($item, $fieldOrVarName = "value", FactoryList $exceptions = null)
    {
        return $this->to($item, $fieldOrVarName, $exceptions);
    }

    public function to($item, $fieldOrVarName = "value", FactoryList $exceptions = null)
    {
        if (gettype($item) !== $type){
            throw new \RuntimeException("item is not of type '{$type}'");
        }
    }
}
