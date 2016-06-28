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

use GanbaroDigital\Defensive\V1\Exceptions\BadAssurance;
use GanbaroDigital\Defensive\V1\Exceptions\BadAssuranceArgs;
use GanbaroDigital\Defensive\V1\Exceptions\DefensiveExceptions;
use GanbaroDigital\Defensive\V1\Interfaces\Assurance;
use GanbaroDigital\DIContainers\V1\Interfaces\FactoryList;

class ComposableAssurance implements Assurance
{
    // saves us having to declare ::__invoke() ourselves
    use InvokeableAssurance;

    /**
     * the partial assurance that we are converting into a
     * composable assurance
     *
     * @var callable
     */
    private $assurance;

    /**
     * the extra parameters to pass into our underlying assurance
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
     * build a composable assurance
     *
     * we take a partial assurance (a assurance that needs multiple
     * parameters), plus the extra parameters, so that it can be called
     * from our EnsureAllOf and EnsureAnyOneOf classes
     *
     * @param  callable $assurance
     *         the partial assurance that we are wrapping
     * @param  array $extra
     *         the extra param(s) to pass into the underlying assurance
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return Assurance
     *         the assurance you can use
     */
    public function __construct($assurance, $extra, FactoryList $exceptions = null)
    {
        // make sure we have some exceptions
        if ($exceptions === null) {
            $exceptions = new DefensiveExceptions;
        }
        $this->exceptions = $exceptions;

        // robustness!
        if (!is_callable($assurance)) {
            throw $this->exceptions['BadAssurance::newFromInputParameter']($assurance, '$assurance');
        }
        if (!is_array($extra)) {
            throw $this->exceptions['BadAssuranceArgs::newFromInputParameter']($extra, '$extra');
        }

        // remember what we have
        $this->assurance = $assurance;
        $this->extra = $extra;
    }

    /**
     * build a composable assurance
     *
     * we take a partial assurance (a assurance that needs multiple
     * parameters), plus the extra parameters, so that it can be called
     * from our EnsureAllOf and EnsureAnyOneOf classes
     *
     * @param  callable $assurance
     *         the partial assurance that we are wrapping
     * @param  array $extra
     *         the extra param(s) to pass into the underlying assurance
     * @param  FactoryList|null $exceptions
     *         the functions to call when we want to throw an exception
     * @return Assurance
     *         the assurance you can use
     */
    public static function apply($assurance, $extra, FactoryList $exceptions = null)
    {
        return new static($assurance, $extra, $exceptions);
    }

    /**
     * throws exception if our underlying assurance isn't met
     *
     * @param  mixed $data
     *         the data to be examined by our underlying assurance
     * @param  string $fieldOrVarName
     *         what is the name of $data in the calling code?
     * @return void
     */
    public function to($data, $fieldOrVarName = "value")
    {
        // what are we passing into our underlying assurance?
        $args = array_merge([$data], $this->extra, [$fieldOrVarName]);

        // ask the assurance if it has been met
        //
        // it is the responsibility of the assurance to throw an exception
        // if the assurance is not met
        call_user_func_array($this->assurance, $args);
    }
}
