<?php

/**
 * Craft JWT plugin for Craft CMS 3.x
 *
 * Enable authentication to Craft through the use of Javascript Web Tokens (JWT)
 *
 * @link      https://edenspiekermann.com
 * @copyright Copyright (c) 2019 Mike Pierce
 */

namespace edenspiekermann\craftjwt;

use edenspiekermann\craftjwt\services\JWT as JWTService;
use edenspiekermann\craftjwt\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\web\Application;
use Firebase\JWT\JWT;

use yii\base\Event;

/**
 * Class CraftJwt
 *
 * @author    Mike Pierce
 * @package   CraftJwt
 * @since     1.0.0
 *
 * @property  JWTService $jWT
 */
class CraftJwt extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var CraftJwt
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Craft::$app->on(Application::EVENT_INIT, function (Event $event) {
            $headers = Craft::$app->request->headers;
            Craft::dd($headers);
            $secretKey = self::$plugin->getSettings()->secretKey;
            $jwt = Craft::$app->request->getQueryParam('jwt');

            if ($secretKey && $jwt) {
                $value = JWT::decode($jwt, $secretKey, ['HS256']);
                Craft::$app->user->loginByUserId($value->id);
            }

            // Craft::dd($value);
        });

        Craft::info(
            Craft::t(
                'craft-jwt',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        return Craft::$app->view->renderTemplate(
            'craft-jwt/settings',
            [
                'settings' => $this->getSettings()
            ]
        );
    }
}
