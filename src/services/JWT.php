<?php

/**
 * Craft JWT plugin for Craft CMS 3.x
 *
 * Enable authentication to Craft through the use of JSON Web Tokens (JWT)
 *
 * @link      https://edenspiekermann.com
 * @copyright Copyright (c) 2019 Mike Pierce
 */

namespace edenspiekermann\craftjwt\services;

use edenspiekermann\craftjwt\CraftJwt;

use Craft;
use craft\base\Component;

/**
 * @author    Mike Pierce
 * @package   CraftJwt
 * @since     1.0.0
 */
class JWT extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';
        // Check our Plugin's settings for `someAttribute`
        if (CraftJwt::$plugin->getSettings()->someAttribute) { }

        return $result;
    }
}
