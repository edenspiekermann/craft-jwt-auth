<?php

/**
 * Craft JWT Auth plugin for Craft CMS 3.x
 *
 * Enable authentication to Craft through the use of JSON Web Tokens (JWT)
 *
 * @link      https://edenspiekermann.com
 * @copyright Copyright (c) 2019 Mike Pierce
 */

namespace edenspiekermann\craftjwtauth\assetbundles\CraftJwtAuth;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Mike Pierce
 * @package   CraftJwtAuth
 * @since     0.1.0
 */
class CraftJwtAuthAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@edenspiekermann/craftjwtauth/assetbundles/craftjwtauth/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/CraftJwtAuth.js',
        ];

        $this->css = [
            'css/CraftJwtAuth.css',
        ];

        parent::init();
    }
}
