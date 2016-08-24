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

use GanbaroDigital\Defensive\V1\Exceptions\BadAssurance;
use GanbaroDigital\Defensive\V1\Exceptions\BadAssuranceArgs;
use GanbaroDigital\Defensive\V1\Exceptions\BadAssurancesList;
use GanbaroDigital\Defensive\V1\Exceptions\BadCallable;
use GanbaroDigital\Defensive\V1\Exceptions\BadCheck;
use GanbaroDigital\Defensive\V1\Exceptions\BadCheckArgs;
use GanbaroDigital\Defensive\V1\Exceptions\BadChecksList;
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirement;
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirements;
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirementArgs;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveExceptions;
use GanbaroDigital\Defensive\V1\Exceptions\EmptyAssurancesList;
use GanbaroDigital\Defensive\V1\Exceptions\EmptyChecksList;
use GanbaroDigital\Defensive\V1\Exceptions\EmptyRequirementsList;
use GanbaroDigital\Defensive\V1\Exceptions\UnreachableCodeExecuted;
use GanbaroDigital\Defensive\V1\Exceptions\UnsupportedType;
use GanbaroDigital\Defensive\V1\Exceptions\UnsupportedValue;
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;
use PHPUnit_Framework_TestCase;

/**
 * @coversDefaultClass GanbaroDigital\Defensive\V1\Exceptions\DefensiveExceptions
 */
class DefensiveExceptionsTest extends PHPUnit_Framework_TestCase
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

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(DefensiveExceptions::class, $unit);
    }

    /**
     * @covers ::__construct
     */
    public function testIsFactoryList()
    {
        // ----------------------------------------------------------------
        // setup your test

        // ----------------------------------------------------------------
        // perform the change

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(FactoryList::class, $unit);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadAssurance_newFromInputParameter()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadAssurance::newFromInputParameter'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadAssurance::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadAssurance_newFromVar()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadAssurance::newFromVar'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadAssurance::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadAssuranceArgs_newFromInputParameter()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadAssuranceArgs::newFromInputParameter'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadAssuranceArgs::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadAssuranceArgs_newFromVar()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadAssuranceArgs::newFromVar'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadAssuranceArgs::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadAssurancesList_newFromInputParameter()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadAssurancesList::newFromInputParameter'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadAssurancesList::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadAssurancesList_newFromVar()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadAssurancesList::newFromVar'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadAssurancesList::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_EmptyAssurancesList_newFromInputParameter()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['EmptyAssurancesList::newFromInputParameter'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(EmptyAssurancesList::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_EmptyAssurancesList_newFromVar()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['EmptyAssurancesList::newFromVar'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(EmptyAssurancesList::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadCallable_newFromInputParameter()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadCallable::newFromInputParameter'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadCallable::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadCallable_newFromVar()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadCallable::newFromVar'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadCallable::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadCheckArgs_newFromInputParameter()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadCheckArgs::newFromInputParameter'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadCheckArgs::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadCheck_newFromVar()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadCheck::newFromVar'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadCheck::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadCheck_newFromInputParameter()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadCheck::newFromInputParameter'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadCheck::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadCheckArgs_newFromVar()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadCheckArgs::newFromVar'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadCheckArgs::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadRequirement_newFromInputParameter()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadRequirement::newFromInputParameter'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadRequirement::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadChecksList_newFromInputParameter()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadChecksList::newFromInputParameter'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadChecksList::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadChecksList_newFromVar()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadChecksList::newFromVar'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadChecksList::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_EmptyChecksList_newFromInputParameter()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['EmptyChecksList::newFromInputParameter'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(EmptyChecksList::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_EmptyChecksList_newFromVar()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['EmptyChecksList::newFromVar'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(EmptyChecksList::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadRequirement_newFromVar()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadRequirement::newFromVar'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadRequirement::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadRequirementArgs_newFromInputParameter()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadRequirementArgs::newFromInputParameter'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadRequirementArgs::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadRequirementArgs_newFromVar()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadRequirementArgs::newFromVar'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadRequirementArgs::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadRequirements_newFromInputParameter()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadRequirements::newFromInputParameter'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadRequirements::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_BadRequirements_newFromVar()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['BadRequirements::newFromVar'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(BadRequirements::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_EmptyRequirementsList_newFromInputParameter()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['EmptyRequirementsList::newFromInputParameter'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(EmptyRequirementsList::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_EmptyRequirementsList_newFromVar()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['EmptyRequirementsList::newFromVar'];
        $exception = $factory(false, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(EmptyRequirementsList::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_UnreachableCodeExecuted_newAlert()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['UnreachableCodeExecuted::newAlert'];
        $exception = $factory();

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(UnreachableCodeExecuted::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_UnsupportedType_newFromInputParameter()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['UnsupportedType::newFromInputParameter'];
        $exception = $factory(null, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(UnsupportedType::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_UnsupportedType_newFromVar()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['UnsupportedType::newFromVar'];
        $exception = $factory(null, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(UnsupportedType::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_UnsupportedValue_newFromInputParameter()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['UnsupportedValue::newFromInputParameter'];
        $exception = $factory(null, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(UnsupportedValue::class, $exception);
    }

    /**
     * @covers ::offsetGet
     */
    public function test_has_factory_for_UnsupportedValue_newFromVar()
    {
        // ----------------------------------------------------------------
        // setup your test

        $unit = new DefensiveExceptions;

        // ----------------------------------------------------------------
        // perform the change

        $factory = $unit['UnsupportedValue::newFromVar'];
        $exception = $factory(null, '$data');

        // ----------------------------------------------------------------
        // test the results

        $this->assertInstanceOf(UnsupportedValue::class, $exception);
    }
}
