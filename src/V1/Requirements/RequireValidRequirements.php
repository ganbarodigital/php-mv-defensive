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

namespace GanbaroDigital\Defensive\V1\Requirements;

use GanbaroDigital\Defensive\V1\Exceptions\BadRequirement;
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirements;
use GanbaroDigital\Defensive\V1\Exceptions\BadRequirementArgs;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveExceptions;
use GanbaroDigital\Defensive\V1\Exceptions\UnsupportedType;
use GanbaroDigital\Defensive\V1\Interfaces\Requirement;
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class RequireValidRequirements implements Requirement
{
    /**
     * the exceptions we should throw
     *
     * @var FactoryList
     */
    protected $exceptions;

    /**
     * create a Requirement that is ready to execute
     *
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return RequireValidRequirements
     */
    public function __construct(FactoryList $exceptions = null)
    {
        // make sure we have exceptions to use
        if ($exceptions === null) {
            $exceptions = new DefensiveExceptions;
        }
        $this->exceptions = $exceptions;
    }

    /**
     * make sure that we have a list of valid requirements to work with
     *
     * @param array $requirements
     *        the list of requirements to check
     * @param string $fieldOrVarName
     *        what is the name of $data in the calling code?
     * @return void
     */
    public function __invoke($requirements, $fieldOrVarName = "value")
    {
        return $this->to($requirements, $fieldOrVarName);
    }

    /**
     * create a Requirement that is ready to execute
     *
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return RequireValidRequirements
     */
    public static function apply(FactoryList $exceptions = null)
    {
        return new static($exceptions);
    }

    /**
     * make sure that we have a list of valid requirements to work with
     *
     * @param array $requirements
     *        the list of requirements to check
     * @param string $fieldOrVarName
     *        what is the name of $data in the calling code?
     * @return void
     */
    public function to($requirements, $fieldOrVarName = "value")
    {
        // we do not use Reflections RequireTraversable here because then
        // Reflections cannot depend upon this library
        if (!is_array($requirements)) {
            throw $this->exceptions['BadRequirements::newFromRequirementsList']($requirements, $fieldOrVarName);
        }
        if (empty($requirements)) {
            throw $this->exceptions['BadRequirements::newFromEmptyList']($requirements, $fieldOrVarName);
        }
        foreach ($requirements as $requirement) {
            if (!$requirement instanceof Requirement) {
                throw $this->exceptions['BadRequirement::newFromRequirement']($requirement, $fieldOrVarName);
            }
        }
    }
}
