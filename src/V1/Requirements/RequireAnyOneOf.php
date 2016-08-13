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

use GanbaroDigital\Defensive\V1\Exceptions\DefensiveExceptions;
use GanbaroDigital\Defensive\V1\Interfaces\ListRequirement;
use GanbaroDigital\Defensive\V1\Interfaces\Requirement;
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class RequireAnyOneOf implements Requirement, ListRequirement
{
    // saves us having to declare ::__invoke() ourselves
    use InvokeableRequirement;

    // saves us having to declare ::toList() ourselves
    use ListableRequirement;

    /**
     * the requirements to apply
     *
     * @var array<Requirement>
     */
    private $requirements = [];

    /**
     * the exceptions to use
     *
     * @var FactoryList
     */
    private $exceptions;

    /**
     * create a Requirement that is ready to execute
     *
     * @param array $requirements
     *        a list of the requirements to apply
     * @param FactoryList|null $exceptions
     *        the functions to call when we want to throw an exception
     */
    public function __construct($requirements, FactoryList $exceptions = null)
    {
        // make sure we have exceptions to use
        if ($exceptions === null) {
            $exceptions = new DefensiveExceptions;
        }
        $this->exceptions = $exceptions;

        // robustness
        RequireValidRequirements::apply()->toList($requirements);

        // we're good (for now)
        $this->requirements = $requirements;
    }

    /**
     * create a Requirement that is ready to execute
     *
     * @param array $requirements
     *        a list of the requirements to apply
     * @param FactoryList $exceptions
     *        the functions to call when we want to throw an exception
     */
    public static function apply($requirements, FactoryList $exceptions = null)
    {
        return new static($requirements, $exceptions);
    }

    /**
     * throws exception if none of our requirements are met
     *
     * @param  mixed $data
     *         the data to be examined by each requirement in turn
     * @param  string $fieldOrVarName
     *         what is the name of $data in the calling code?
     * @return void
     */
    public function to($data, $fieldOrVarName = "value")
    {
        // what are we passing into our requirements?
        $args = [$data, $fieldOrVarName];

        // are any of our requirements met?
        foreach ($this->requirements as $requirement) {
            // ask the requirement if it has been met
            //
            // it is the responsibility of the requirement to throw an exception
            // if the requirement has not been met
            try {
                call_user_func_array($requirement, $args);
                return;
            }
            catch (\Exception $e) {
                // requirement not met ... continue
            }
        }

        // if we get here, our requirements are not met :(
        throw $this->exceptions['UnsupportedValue::newFromInputParameter']($data, $fieldOrVarName);
    }
}
