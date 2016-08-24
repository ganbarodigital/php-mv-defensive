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
use GanbaroDigital\Defensive\V1\Interfaces\Check;
use GanbaroDigital\Defensive\V1\Interfaces\ListCheck;
use GanbaroDigital\Defensive\V1\Requirements\RequireValidChecks;
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

/**
 * applies our list of checks to a piece of data
 */
class IsAllOf implements Check, ListCheck
{
    // saves us having to implement inspectList() ourselves
    use ListableCheck;

    /**
     * the list of checks we want to apply
     *
     * @var array
     */
    private $checks;

    /**
     * create a check that is ready to execute
     *
     * @param array $checks
     *        a list of the checks to apply
     * @param FactoryList|null $exceptions
     *        the functions to call when we want to throw an exception
     */
    public function __construct($checks, FactoryList $exceptions = null)
    {
        // make sure we have exceptions to use
        if ($exceptions === null) {
            $exceptions = new DefensiveExceptions;
        }

        // robustness
        RequireValidChecks::apply($exceptions)->toList($checks);

        // we're good (for now)
        $this->checks = $checks;
    }

    /**
     * create a check that is ready to execute
     *
     * @param array $checks
     *        a list of the checks to apply
     * @param FactoryList|null $exceptions
     *        the functions to call when we want to throw an exception
     */
    public static function using($checks, FactoryList $exceptions = null)
    {
        return new static($checks, $exceptions);
    }

    /**
     * applies our list of checks to a piece of data
     *
     * @param  mixed $fieldOrVar
     *         the data to be examined by each check in turn
     * @return bool
     *         TRUE if all checks pass
     *         FALSE otherwise
     */
    public function inspect($fieldOrVar)
    {
        // what are we passing into our checks?
        $args = [$fieldOrVar];

        // are any of our checks met?
        foreach ($this->checks as $check) {
            // ask the check if it has been met
            if (!call_user_func_array([$check, 'inspect'], $args)) {
                return false;
            }
        }

        // if we get here, then all checks have passed
        return true;
    }
}
