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
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;

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

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['siteActionTrigger1'] = 'craft-jwt/j-w-t';
            }
        );

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['cpActionTrigger1'] = 'craft-jwt/j-w-t/do-something';
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) { }
            }
        );

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
