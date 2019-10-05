<?php

/**
 * Craft JWT Auth plugin for Craft CMS 3.x
 *
 * Enable authentication to Craft through the use of JSON Web Tokens (JWT)
 *
 * @link      https://edenspiekermann.com
 * @copyright Copyright (c) 2019 Mike Pierce
 */

namespace edenspiekermann\craftjwtauth\controllers;

use craft\web\Controller;

/**
 * @author    Mike Pierce
 * @package   CraftJwtAuth
 * @since     0.1.0
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
    protected $allowAnonymous = [];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    // TODO: Add an action to generate a JWT for a specific or the logged in user.
    // public function actionGenerate()
    // {
    //     $result = 'Welcome to the JWTController actionGenerate() method';

    //     return $result;
    // }
}
