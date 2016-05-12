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

namespace GanbaroDigital\Defensive\V1\Exceptions;

use GanbaroDigital\DIContainers\V1\FactoryList\Containers\FactoryListContainer;

class DefensiveExceptions extends FactoryListContainer
{
    public function __construct()
    {
        // the exceptions that our library throws
        $ourExceptions = [
            'BadRequirement::newFromRequirement' => [ BadRequirement::class, 'newFromRequirement' ],
            'BadRequirementArgs::newFromRequirementArgs' => [ BadRequirementArgs::class, 'newFromRequirementArgs' ],
            'BadRequirements::newFromRequirementsList' => [ BadRequirements::class, 'newFromRequirementsList' ],
            'BadRequirements::newFromEmptyList' => [ BadRequirements::class, 'newFromEmptyList' ],
            'ContractFailed::newFromBadValue' => [ ContractFailed::class, 'newFromBadValue' ],
            'UnreachableCodeReached::newAlert' => [ UnreachableCodeReached::class, 'newAlert' ],
            'UnsupportedType::newFromVar' => [ UnsupportedType::class, 'newFromVar' ],
            'UnsupportedValue::newFromVar' => [ UnsupportedValue::class, 'newFromVar' ],
        ];

        // build it
        parent::__construct($ourExceptions);
    }
}
