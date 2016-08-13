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

namespace GanbaroDigital\Defensive\V1\Assurances;

use GanbaroDigital\Defensive\V1\Exceptions\DefensiveExceptions;
use GanbaroDigital\Defensive\V1\Interfaces\Assurance;
use GanbaroDigital\Defensive\V1\Interfaces\ListAssurance;
use GanbaroDigital\Defensive\V1\Requirements\RequireValidAssurances;
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class EnsureAnyOneOf implements Assurance, ListAssurance
{
    // saves us having to declare ::__invoke() ourselves
    use InvokeableAssurance;

    // saves us having to declare ::toList() ourselves
    use ListableAssurance;

    /**
     * the assurances to apply
     *
     * @var array<Assurance>
     */
    private $assurances = [];

    /**
     * the exceptions to use
     *
     * @var FactoryList
     */
    private $exceptions;

    /**
     * create an Assurance that is ready to execute
     *
     * @param array $assurances
     *        a list of the assurances to apply
     * @param FactoryList|null $exceptions
     *        the functions to call when we want to throw an exception
     */
    public function __construct($assurances, FactoryList $exceptions = null)
    {
        // make sure we have exceptions to use
        if ($exceptions === null) {
            $exceptions = new DefensiveExceptions;
        }
        $this->exceptions = $exceptions;

        // robustness
        RequireValidAssurances::apply()->toList($assurances);

        // we're good (for now)
        $this->assurances = $assurances;
    }

    /**
     * create an Assurance that is ready to execute
     *
     * @param array $assurances
     *        a list of the assurances to apply
     * @param FactoryList $exceptions
     *        the functions to call when we want to throw an exception
     */
    public static function apply($assurances, FactoryList $exceptions = null)
    {
        return new static($assurances, $exceptions);
    }

    /**
     * throws exception if none of our assurances are met
     *
     * @param  mixed $data
     *         the data to be examined by each assurance in turn
     * @param  string $fieldOrVarName
     *         what is the name of $data in the calling code?
     * @return void
     */
    public function to($data, $fieldOrVarName = "value")
    {
        // what are we passing into our assurances?
        $args = [$data, $fieldOrVarName];

        // are any of our assurances met?
        foreach ($this->assurances as $assurance) {
            // ask the assurance if it has been met
            //
            // it is the responsibility of the assurance to throw an exception
            // if the assurance has not been met
            try {
                call_user_func_array($assurance, $args);
                return;
            }
            catch (\Exception $e) {
                // assurance not met ... continue
            }
        }

        // if we get here, our assurances are not met :(
        throw $this->exceptions['UnsupportedValue::newFromVar']($data, $fieldOrVarName);
    }
}
