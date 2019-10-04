<?php

/**
 * Craft JWT plugin for Craft CMS 3.x
 *
 * Enable authentication to Craft through the use of JSON Web Tokens (JWT)
 *
 * @link      https://edenspiekermann.com
 * @copyright Copyright (c) 2019 Mike Pierce
 */

namespace edenspiekermann\craftjwt\controllers;

use edenspiekermann\craftjwt\CraftJwt;

use Craft;
use craft\web\Controller;

/**
 * @author    Mike Pierce
 * @package   CraftJwt
 * @since     1.0.0
 */
class JWTController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'do-something'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $result = 'Welcome to the JWTController actionIndex() method';

        return $result;
    }

    /**
     * @return mixed
     */
    public function actionDoSomething()
    {
        $result = 'Welcome to the JWTController actionDoSomething() method';

        return $result;
    }
}
