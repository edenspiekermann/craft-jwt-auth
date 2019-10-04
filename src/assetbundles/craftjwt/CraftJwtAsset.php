<?php

/**
 * Craft JWT plugin for Craft CMS 3.x
 *
 * Enable authentication to Craft through the use of JSON Web Tokens (JWT)
 *
 * @link      https://edenspiekermann.com
 * @copyright Copyright (c) 2019 Mike Pierce
 */

namespace edenspiekermann\craftjwt\assetbundles\CraftJwt;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Mike Pierce
 * @package   CraftJwt
 * @since     0.1.0
 */
class CraftJwtAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@edenspiekermann/craftjwt/assetbundles/craftjwt/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/CraftJwt.js',
        ];

        $this->css = [
            'css/CraftJwt.css',
        ];

        parent::init();
    }
}
