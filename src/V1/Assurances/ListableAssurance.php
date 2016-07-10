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
use InvalidArgumentException;
use stdClass;
use Traversable;

trait ListableAssurance
{
    /**
     * throws exceptions if any of our assurances are not met
     *
     * this is an alias of toList() for readability
     *
     * @param  mixed $list
     *         the data to be examined by each assurance in turn
     * @param  string $fieldOrVarName
     *         what is the name of $list in the calling code?
     * @return void
     */
    public function inspectList($list, $fieldOrVarName = "value")
    {
        $this->toList($list, $fieldOrVarName);
    }

    /**
     * throws exceptions if any of our assurances are not met
     *
     * the inspection defined in the to() method is applied to every element
     * of the list passed in
     * 
     * @param  mixed $list
     *         the data to be examined by each assurance in turn
     * @param  string $fieldOrVarName
     *         what is the name of $list in the calling code?
     * @return void
     */
    public function toList($list, $fieldOrVarName = "value")
    {
        // do we have an array, or an object?
        if (is_array($list)) {
            $this->traverseArray($list, $fieldOrVarName);
        }
        else if ($list instanceof Traversable) {
            $this->traverseArray($list, $fieldOrVarName);
        }
        else if ($list instanceof stdClass) {
            $this->traverseObject($list, $fieldOrVarName);
        }
        else {
            throw new InvalidArgumentException($fieldOrVarName . ' is not traversable');
        }
    }

    /**
     * apply our assurance to the elements of an array
     *
     * @param  mixed $list
     *         the array (or array-like object) to iterate over
     * @param  string $fieldOrVarName
     *         what is the name of $list in the calling code?
     * @return void
     */
    private function traverseArray($list, $fieldOrVarName)
    {
        // apply the requirement to each element of our list
        foreach ($list as $key => $data) {
            $name = $fieldOrVarName . '[' . $key . ']';
            $this->to($data, $name);
        }
    }

    /**
     * apply our assurance to the properties of an object
     *
     * @param  object $list
     *         the object to iterate over
     * @param  string $fieldOrVarName
     *         what is the name of $list in the calling code?
     * @return void
     */
    private function traverseObject($list, $fieldOrVarName)
    {
        // apply the requirement to each element of our list
        foreach ($list as $key => $data) {
            $name = $fieldOrVarName . '->' . $key;
            $this->to($data, $name);
        }
    }
}
