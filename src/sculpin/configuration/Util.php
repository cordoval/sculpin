<?php

/*
 * This file is a part of Sculpin.
 *
 * (c) Dragonfly Development Inc.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace sculpin\configuration;

use sculpin\Util as SculpinUtil;

class Util {

    /**
     * Test if array is an associative array
     *
     * Note that this function will return true if an array is empty. Meaning
     * empty arrays will be treated as if they are associative arrays.
     *
     * @param array $arr
     * @return boolean
     */
    static public function IS_ASSOC(array $arr)
    {
        return SculpinUtil::IS_ASSOC($arr);
    }
    
    /**
     * Merge the contents of one thingy into another thingy
     * @param mixed $to
     * @param mixed $from
     * @param bool $clobber
     */
    static public function MERGE_ASSOC_ARRAY($to, $from, $clobber = true)
    {
        return SculpinUtil::MERGE_ASSOC_ARRAY($to, $from, $clobber);
    }

    /**
     * Merge configuration instances
     * @param array $configurations
     */
    static public function MERGE_CONFIGURATIONS(array $configurations) {
        $config = array();
        foreach ( $configurations as $configuration ) {
            $config = self::MERGE_ASSOC_ARRAY($config, $configuration->export());
        }
        return new Configuration($config);
    }

}