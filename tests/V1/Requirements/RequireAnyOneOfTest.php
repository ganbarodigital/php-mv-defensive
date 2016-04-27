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

use GanbaroDigital\Defensive\V1\Exceptions\UnsupportedType;
use GanbaroDigital\Defensive\V1\Requirements\RequireAnyOneOf;
use GanbaroDigital\Defensive\V1\Specifications\Requirement;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * @coversDefaultClass GanbaroDigital\Defensive\V1\Requirements\RequireAnyOneOf
 */
class RequireAnyOneOfTest extends PHPUnit_Framework_TestCase
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

        $unit = new RequireAnyOneOf([ new RequireAnyOneOfTest_RequireNull ]);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(RequireAnyOneOf::class, $unit);
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

        $unit = new RequireAnyOneOf([ new RequireAnyOneOfTest_RequireNull ]);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(Requirement::class, $unit);
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
            new RequireAnyOneOfTest_RequireNull,
            new RequireAnyOneOfTest_RequireNumeric,
        ];

        $unit = new RequireAnyOneOf($requirements);

        // ----------------------------------------------------------------
        // perform the change

        $unit(1.0, "value");

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
            new RequireAnyOneOfTest_RequireNull,
            new RequireAnyOneOfTest_RequireNumeric,
        ];

        // ----------------------------------------------------------------
        // perform the change

        RequireAnyOneOf::apply($requirements)->to(1.0, "value");

        // ----------------------------------------------------------------
        // test the results
        //
        // if we get here, then no exception has been thrown :)
    }

    /**
     * @covers ::__construct
     * @dataProvider provideBadRequirements
     * @expectedException GanbaroDigital\Defensive\V1\Exceptions\BadRequirements
     */
    public function testMustProvideAnArrayOfRequirements($requirements)
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        RequireAnyOneOf::apply($requirements)->to([], "value");
    }

    /**
     * @covers ::__construct
     * @expectedException GanbaroDigital\Defensive\V1\Exceptions\BadRequirements
     */
    public function testArrayOfRequirementsCannotBeEmpty()
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        RequireAnyOneOf::apply([])->to(null, "value");
    }

    /**
     * @covers ::apply
     * @covers ::__construct
     * @dataProvider provideInvalidRequirements
     * @expectedException GanbaroDigital\Defensive\V1\Exceptions\BadRequirement
     */
    public function testRequirementsArrayMustContainValidRequirements($requirements)
    {
        // ----------------------------------------------------------------
        // setup your test


        // ----------------------------------------------------------------
        // perform the change

        RequireAnyOneOf::apply($requirements)->to([], "value");
    }

    /**
     * @covers ::apply
     * @covers ::to
     */
    public function testWillMatchAnyRequirementGiven()
    {
        // ----------------------------------------------------------------
        // setup your test

        // this group accepts null and numerics
        $requirements = [
            new RequireAnyOneOfTest_RequireNull,
            new RequireAnyOneOfTest_RequireNumeric
        ];

        // ----------------------------------------------------------------
        // perform the change

        // if these do not match, an exception is thrown
        RequireAnyOneOf::apply($requirements)->to(null, "value");
        RequireAnyOneOf::apply($requirements)->to(1.0, "value");
    }

    /**
     * @covers ::apply
     * @covers ::to
     * @dataProvider provideGroup2NoMatches
     * @expectedException GanbaroDigital\Defensive\V1\Exceptions\UnsupportedValue
     */
    public function testThrowsExceptionIfNothingMatches($item)
    {
        // ----------------------------------------------------------------
        // setup your test

        // this group accepts null and strings
        $requirements = [
            new RequireAnyOneOfTest_RequireNull,
            new RequireAnyOneOfTest_RequireString
        ];

        // ----------------------------------------------------------------
        // perform the change

        RequireAnyOneOf::apply($requirements)->to($item, "\$item");
    }

    public function provideBadRequirements()
    {
        return [
            [ null ],
            [ false ],
            [ true ],
            [ 3.1415927 ],
            [ 100 ],
            [ new stdClass ]
        ];
    }

    public function provideInvalidRequirements()
    {
        return [
            [ [1, 2, 3] ],
        ];
    }

    public function provideBadRequirementData()
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
}

class RequireAnyOneOfTest_RequireNull implements Requirement
{
    public function __invoke($item, $fieldOrVarName = "value", $exceptions = null)
    {
        return $this->to($item, $fieldOrVarName, $exceptions);
    }

    public function to($item, $fieldOrVarName = "value", $exceptions = null)
    {
        if (!is_null($item)) {
            throw new \RuntimeException("item is not null");
        }
    }
}

class RequireAnyOneOfTest_RequireNumeric implements Requirement
{
    public function __invoke($item, $fieldOrVarName = "value", $exceptions = null)
    {
        return $this->to($item, $fieldOrVarName, $exceptions);
    }

    public function to($item, $fieldOrVarName = "value", $exceptions = null)
    {
        if(!is_numeric($item)) {
            throw new \RuntimeException("item is not numeric");
        }
    }
}

class RequireAnyOneOfTest_RequireString implements Requirement
{
    public function __invoke($item, $fieldOrVarName = "value", $exceptions = null)
    {
        return $this->to($item, $fieldOrVarName, $exceptions);
    }

    public function to($item, $fieldOrVarName = "value", $exceptions = null)
    {
        if (!is_string($item)) {
            throw new \RuntimeException("item is not a string");
        }
    }
}
