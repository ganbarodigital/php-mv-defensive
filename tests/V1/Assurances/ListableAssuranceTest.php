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

use stdClass;
use ArrayObject;
use GanbaroDigital\Defensive\V1\Assurances\InvokeableAssurance;
use GanbaroDigital\Defensive\V1\Assurances\ListableAssurance;
use GanbaroDigital\Defensive\V1\Interfaces\Assurance;
use GanbaroDigital\Defensive\V1\Interfaces\ListAssurance;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass GanbaroDigital\Defensive\V1\Assurances\ListableAssurance
 */
class ListableAssuranceTest extends PHPUnit_Framework_TestCase
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

        $unit = new ListableAssuranceTest_Assurance;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(Assurance::class, $unit);
    }

    /**
     * @coversNothing
     */
    public function test_is_part_of_ListAssurance_interface()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new ListableAssuranceTest_Assurance;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(ListAssurance::class, $unit);
    }

    /**
     * @covers ::toList
     */
    public function test_can_inspect_an_array_of_data_via_toList()
    {
        // ----------------------------------------------------------------
        // setup your test

        $fieldName = '$alfred';
        $expectedData = 1.0;
        $expectedField = "{$fieldName}[0]";
        $unit = new ListableAssuranceTest_Assurance;

        // ----------------------------------------------------------------
        // perform the change

        $unit->toList([$expectedData], $fieldName);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedField, $unit->toFieldOrVarName);
    }

    /**
     * @covers ::inspectList
     */
    public function test_can_inspect_an_array_of_data_via_inspectList()
    {
        // ----------------------------------------------------------------
        // setup your test

        $fieldName = '$alfred';
        $expectedData = 1.0;
        $expectedField = "{$fieldName}[0]";
        $unit = new ListableAssuranceTest_Assurance;

        // ----------------------------------------------------------------
        // perform the change

        $unit->inspectList([$expectedData], $fieldName);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedField, $unit->toFieldOrVarName);
    }

    /**
     * @covers ::toList
     */
    public function test_can_inspect_a_Traversable_object_via_toList()
    {
        // ----------------------------------------------------------------
        // setup your test

        $fieldName = '$alfred';
        $expectedData = 1.0;
        $expectedField = "{$fieldName}[0]";
        $unit = new ListableAssuranceTest_Assurance;
        $list = new ArrayObject;
        $list[0] = $expectedData;

        // ----------------------------------------------------------------
        // perform the change

        $unit->toList($list, $fieldName);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedField, $unit->toFieldOrVarName);
    }

    /**
     * @covers ::inspectList
     */
    public function test_can_inspect_a_Traversable_object_via_inspectList()
    {
        // ----------------------------------------------------------------
        // setup your test

        $fieldName = '$alfred';
        $expectedData = 1.0;
        $expectedField = "{$fieldName}[0]";
        $unit = new ListableAssuranceTest_Assurance;
        $list = new ArrayObject;
        $list[0] = $expectedData;

        // ----------------------------------------------------------------
        // perform the change

        $unit->inspectList($list, $fieldName);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedField, $unit->toFieldOrVarName);
    }

    /**
     * @covers ::toList
     */
    public function test_can_inspect_a_stdClass_object_via_toList()
    {
        // ----------------------------------------------------------------
        // setup your test

        $fieldName = '$alfred';
        $expectedData = 1.0;
        $expectedField = "{$fieldName}->jones";
        $unit = new ListableAssuranceTest_Assurance;
        $list = new stdClass;
        $list->jones = $expectedData;

        // ----------------------------------------------------------------
        // perform the change

        $unit->toList($list, $fieldName);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedField, $unit->toFieldOrVarName);
    }

    /**
     * @covers ::inspectList
     */
    public function test_can_inspect_a_stdClass_object_via_inspectList()
    {
        // ----------------------------------------------------------------
        // setup your test

        $fieldName = '$alfred';
        $expectedData = 1.0;
        $expectedField = "{$fieldName}->jones";
        $unit = new ListableAssuranceTest_Assurance;
        $list = new stdClass;
        $list->jones = $expectedData;

        // ----------------------------------------------------------------
        // perform the change

        $unit->inspectList($list, $fieldName);

        // ----------------------------------------------------------------
        // test the results

        $this->assertEquals($expectedField, $unit->toFieldOrVarName);
    }

    /**
     * @covers ::toList
     * @expectedException InvalidArgumentException
     * @dataProvider provideNonLists
     */
    public function test_throws_InvalidArgumentException_when_non_list_passed_to_toList($list)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ListableAssuranceTest_Assurance;

        // ----------------------------------------------------------------
        // perform the change

        $unit->toList($list);

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::inspectList
     * @expectedException InvalidArgumentException
     * @dataProvider provideNonLists
     */
    public function test_throws_InvalidArgumentException_when_non_list_passed_to_inspectList($list)
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new ListableAssuranceTest_Assurance;

        // ----------------------------------------------------------------
        // perform the change

        $unit->inspectList($list);

        // ----------------------------------------------------------------
        // test the results
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

class ListableAssuranceTest_Assurance implements Assurance, ListAssurance
{
    use InvokeableAssurance;
    use ListableAssurance;

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
