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

use GanbaroDigital\ExceptionHelpers\V1\BaseExceptions\ParameterisedException;
use GanbaroDigital\ExceptionHelpers\V1\Callers\Filters\FilterBacktraceForTwoCodeCallers;
use GanbaroDigital\ExceptionHelpers\V1\Callers\Filters\FilterCodeCaller;
use GanbaroDigital\HttpStatus\Specifications\HttpStatusProvider;
use GanbaroDigital\HttpStatus\StatusProviders\RequestError\UnprocessableEntityStatusProvider;
use GanbaroDigital\MissingBits\TypeInspectors\GetPrintableType;

class BadRequirements extends ParameterisedException implements DefensiveException, HttpStatusProvider
{
    // we map onto HTTP 422
    use UnprocessableEntityStatusProvider;

    /**
     * create a new exception from the requirements list that has been
     * rejected
     *
     * @param  mixed $list
     *         the requirements list that has been rejected
     * @param  array|null $callerFilter
     *         a list of classnames or partial namespaces to avoid
     *         if null, we use FilterCodeCaller::$DEFAULT_PARTIALS
     * @return BadRequirements
     */
    public static function newFromRequirementsList($list, $callerFilter = null)
    {
        // do we need to provide a filter?
        if (!is_array($callerFilter)) {
            $callerFilter = FilterCodeCaller::$DEFAULT_PARTIALS;
        }

        // who called us?
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $callers = FilterBacktraceForTwoCodeCallers::from($trace, $callerFilter);

        // what is the bad data we've had?
        $type = GetPrintableType::of($list, GetPrintableType::FLAG_CLASSNAME);

        // put it all together
        $exceptionData = [
            "thrownBy" => $callers[0],
            "thrownByName" => $callers[0]->getCaller(),
            "caller" => $callers[1],
            "callerName" => $callers[1]->getCaller(),
            "badRequirements" => $list,
            "badRequirementsType" => $type,
        ];
        $msg = "Bad requirements passed into %thrownByName\$s by %callerName\$s; must be an array of callables";
        return new static($msg, $exceptionData);
    }
}