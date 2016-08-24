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

namespace GanbaroDigital\Defensive\V1\Checks;

use GanbaroDigital\Defensive\V1\Checks\ListableCheck;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveExceptions;
use GanbaroDigital\Defensive\V1\Interfaces\ListCheck;
use GanbaroDigital\Defensive\V1\Interfaces\Check;
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

/**
 * build a composable check
 *
 * we take a partial check (a check that needs multiple parameters),
 * plus the extra parameters, so that it can be called from our
 * IsAllOf and IsAnyOneOf classes
 */
class ComposableCheck implements Check, ListCheck
{
    // save us from implementing inspectList() ourselves
    use ListableCheck;

    /**
     * the partial check that we are converting into a
     * composable check
     *
     * @var callable
     */
    private $check;

    /**
     * the extra parameters to pass into our underlying check
     *
     * @var array
     */
    private $extra;

    /**
     * the exceptions to use
     *
     * @var FactoryList
     */
    private $exceptions;

    /**
     * build a composable check
     *
     * we take a partial check (a check that needs multiple parameters),
     * plus the extra parameters, so that it can be called from our
     * IsAllOf and IsAnyOneOf classes
     *
     * @param  callable $check
     *         the partial check that we are wrapping
     * @param  array $extra
     *         the extra param(s) to pass into the underlying check
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return Check
     *         the check you can use
     */
    public function __construct($check, $extra, FactoryList $exceptions = null)
    {
        // make sure we have some exceptions
        if ($exceptions === null) {
            $exceptions = new DefensiveExceptions;
        }
        $this->exceptions = $exceptions;

        // robustness!
        if (!is_callable($check)) {
            throw $this->exceptions['BadCallable::newFromInputParameter']($check, '$check');
        }
        if (!is_array($extra)) {
            throw $this->exceptions['BadCheckArgs::newFromInputParameter']($extra, '$extra');
        }

        // remember what we have
        $this->check = $check;
        $this->extra = $extra;
    }

    /**
     * does a value pass inspection?
     *
     * @param  mixed $fieldOrVar
     *         the data to be examined
     * @return bool
     *         TRUE if the inspection passes
     *         FALSE otherwise
     */
    public function inspect($fieldOrVar)
    {
        // what are we passing into our underlying check?
        $args = array_append_values([$fieldOrVar], $this->extra);

        // ask the check if it has been met
        return call_user_func_array($this->check, $args);
    }
}
