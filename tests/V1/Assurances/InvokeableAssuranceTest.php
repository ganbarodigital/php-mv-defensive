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

use GanbaroDigital\Defensive\V1\Assurances\InvokeableAssurance;
use GanbaroDigital\Defensive\V1\Interfaces\Assurance;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass GanbaroDigital\Defensive\V1\Assurances\InvokeableAssurance
 */
class InvokeableAssuranceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @coversNothing
     */
    public function testCanInstantiateClassThatUsesTrait()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new InvokeableAssuranceTest_Assurance;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(Assurance::class, $unit);
    }

    /**
     * @coversNothing
     */
    public function test_is_part_of_Assurance_interface()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new InvokeableAssuranceTest_Assurance;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(Assurance::class, $unit);
    }

    /**
     * @covers ::__invoke
     */
    public function test_calls_enclosing_classes_to_method()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedData = 1.0;
        $expectedField = "alfred";
        $unit = new InvokeableAssuranceTest_Assurance;

        // ----------------------------------------------------------------
        // perform the change

        $unit($expectedData, $expectedField);

        // ----------------------------------------------------------------
        // test the results

        $this->assertTrue($unit->toCalled);
    }

    /**
     * @covers ::__invoke
     */
    public function test_passes_data_to_enclosing_classes_to_method()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedData = 1.0;
        $expectedField = "alfred";
        $unit = new InvokeableAssuranceTest_Assurance;

        // ----------------------------------------------------------------
        // perform the change

        $unit($expectedData, $expectedField);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedData, $unit->toData);
    }

    /**
     * @covers ::__invoke
     */
    public function test_passes_fieldOrVarName_to_enclosing_classes_to_method()
    {
        // ----------------------------------------------------------------
        // setup your test

        $expectedData = 1.0;
        $expectedField = "alfred";
        $unit = new InvokeableAssuranceTest_Assurance;

        // ----------------------------------------------------------------
        // perform the change

        $unit($expectedData, $expectedField);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedField, $unit->toFieldOrVarName);
    }
}

class InvokeableAssuranceTest_Assurance implements Assurance
{
    use InvokeableAssurance;

    public $toCalled = false;
    public $toData = null;
    public $toFieldOrVarName = null;

    public function to($item, $fieldOrVarName = "value")
    {
        $this->toCalled = true;
        $this->toData = $item;
        $this->toFieldOrVarName = $fieldOrVarName;
    }
}
