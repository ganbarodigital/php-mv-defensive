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

use GanbaroDigital\Defensive\V1\Checks\ComposableCheck;
use GanbaroDigital\Defensive\V1\Interfaces\Check;
use PHPUnit_Framework_TestCase;
use stdClass;

/**
 * @coversDefaultClass GanbaroDigital\Defensive\V1\Checks\ComposableCheck
 */
class ComposableCheckTest extends PHPUnit_Framework_TestCase
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

        $unit = new ComposableCheck($this->provideFunctionToCompose(), [1, 10]);

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(ComposableCheck::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function testIsCheck()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new ComposableCheck($this->provideFunctionToCompose(), [1, 10]);

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

        $data = [ 1, 2, 3 ];
        $unit = new ComposableCheck($this->provideFunctionToCompose(), [1, 10]);

        // ----------------------------------------------------------------
        // perform the change

        $unit->inspect($data);

        // ----------------------------------------------------------------
        // test the results

    }

    /**
     * @covers ::__construct
     * @dataProvider provideBadChecks
     * @expectedException GanbaroDigital\Defensive\V1\Exceptions\BadCallable
     */
    public function testMustProvideACallable($badCheck)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        new ComposableCheck($badCheck, []);

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::__construct
     * @dataProvider provideBadParameters
     * @expectedException GanbaroDigital\Defensive\V1\Exceptions\BadCheckArgs
     */
    public function testMustProvideArrayOfExtraParameters($badParameters)
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        new ComposableCheck($this->provideFunctionToCompose(), $badParameters);

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::__construct
     */
    public function testArrayOfExtraParametersCanBeEmpty()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        new ComposableCheck($this->provideFunctionToCompose(), []);

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::__construct
     * @covers ::inspectList
     */
    public function test_can_apply_to_a_data_list()
    {
        // ----------------------------------------------------------------
        // setup your test

        $Check = new ComposableCheck($this->provideFunctionToCompose(), [0, 1]);
        $list = [
            [],
            []
        ];

        // ----------------------------------------------------------------
        // perform the change

        $Check->inspectList($list);

        // ----------------------------------------------------------------
        // test the results
    }

    /**
     * @covers ::__construct
     * @covers ::inspectList
     * @dataProvider provideNonListsToTest
     * @expectedException InvalidArgumentException
     */
    public function test_throws_InvalidArgumentException_if_non_list_passed_to_inspectList($list)
    {
        // ----------------------------------------------------------------
        // setup your test

        $Check = new ComposableCheck($this->provideFunctionToCompose(), [0, 1]);

        // ----------------------------------------------------------------
        // perform the change

        $Check->inspectList($list);
    }

    public function provideBadChecks()
    {
        return [
            [ null ],
            [ [] ],
            [ true ],
            [ false ],
            [ 0.0 ],
            [ 3.1415927 ],
            [ 0 ],
            [ 100 ],
            [ new \stdClass ],
            [ STDIN ],
            [ "hello, world!" ]
        ];
    }

    public function provideBadParameters()
    {
        return [
            [ null ],
            [ true ],
            [ false ],
            [ function(){} ],
            [ 0.0 ],
            [ 3.1415927 ],
            [ 0 ],
            [ 100 ],
            [ new \stdClass ],
            [ STDIN ],
            [ "hello, world!" ]
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

    public function provideFunctionToCompose()
    {
        return function($item, $min, $max)
        {
            if (!is_array($item)) {
                throw new \RuntimeException("item is not an array");
            }
            $len = count($item);
            if ($len < $min) {
                return false;
            }
            if ($len > $max) {
                return false;
            }

            return true;
        };
    }
}
