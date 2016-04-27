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
use GanbaroDigital\Defensive\V1\Exceptions\UnsupportedType;
use GanbaroDigital\Defensive\V1\Specifications\Requirement;

class RequireAllOf implements Requirement
{
    /**
     * our list of default exceptions to use
     *
     * @var array
     */
    static public $DEFAULT_EXCEPTIONS = [
        'BadRequirement' => [ BadRequirement::class, 'newFromRequirement' ],
        'BadRequirements' => [ BadRequirements::class, 'newFromRequirementsList' ],
        'BadRequirementArgs' => [ BadRequirementArgs::class, 'newFromRequirementData' ],
        'UnsupportedType' => [ UnsupportedType::class, 'newFromVar' ],
    ];

    /**
     * create a Requirement that is ready to execute
     *
     * @param array $requirements
     *        a list of the requirements to apply
     * @param array $exception
     *        the functions to call when we want to throw an exception
     */
    public function __construct($requirements, $exceptions = null)
    {
        // make sure we have exceptions to use
        if (!is_array($exceptions)) {
            $exceptions = self::$DEFAULT_EXCEPTIONS;
        }

        // we do not use Reflections RequireTraversable here because then
        // Reflections cannot depend upon this library
        if (!is_array($requirements)) {
            throw $exceptions['BadRequirements']($requirements);
        }
        if (empty($requirements)) {
            throw $exceptions['BadRequirements']($requirements);
        }
        foreach ($requirements as $requirement) {
            if (!$requirement instanceof Requirement) {
                throw $exceptions['BadRequirement']($requirement);
            }
        }

        // we're good (for now)
        $this->requirements = $requirements;
    }

    /**
     * create a Requirement that is ready to execute
     *
     * @param array $requirements
     *        a list of the requirements to apply
     * @param array $exception
     *        the functions to call when we want to throw an exception
     */
    public static function apply($requirements, $exceptions = null)
    {
        return new static($requirements, $exceptions);
    }

    /**
     * throws exceptions if any of our requirements are not met
     *
     * @param  mixed $data
     *         the data to be examined by each requirement in turn
     * @param  string $fieldOrVarName
     *         what is the name of $data in the calling code?
     * @param  array|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return void
     */
    public function __invoke($data, $fieldOrVarName = "value", $exceptions = null)
    {
        return $this->to($data, $fieldOrVarName, $exceptions);
    }

    /**
     * throws exceptions if any of our requirements are not met
     *
     * @param  mixed $data
     *         the data to be examined by each requirement in turn
     * @param  string $fieldOrVarName
     *         what is the name of $data in the calling code?
     * @param  array|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return void
     */
    public function to($data, $fieldOrVarName = "value", $exceptions = null)
    {
        // make sure we have exceptions to use
        if (!is_array($exceptions)) {
            $exceptions = self::$DEFAULT_EXCEPTIONS;
        }

        // what are we passing into our requirements?
        $args = [$data, $fieldOrVarName, $exceptions];

        // are any of our requirements met?
        foreach ($this->requirements as $requirement) {
            // ask the requirement if it has been met
            //
            // it is the responsibility of the requirement to throw an exception
            // if the requirement is not met
            call_user_func_array($requirement, $args);
        }
    }
}
