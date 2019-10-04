<?php

/**
 * Craft JWT plugin for Craft CMS 3.x
 *
 * Enable authentication to Craft through the use of JSON Web Tokens (JWT)
 *
 * @link      https://edenspiekermann.com
 * @copyright Copyright (c) 2019 Mike Pierce
 */

namespace edenspiekermann\craftjwt;

use edenspiekermann\craftjwt\services\JWT as JWTService;
use edenspiekermann\craftjwt\models\Settings;

use Craft;
use craft\base\Plugin;
use craft\elements\User;
use craft\helpers\StringHelper;
use craft\web\Application;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;

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
            // Get relevant settings
            $secretKey = self::$plugin->getSettings()->secretKey;
            $autoCreateUser = self::$plugin->getSettings()->autoCreateUser;
            $allowPublicRegistration = Craft::$app->getProjectConfig()->get('users.allowPublicRegistration') ?: false;

            // Look for an access token in the settings
            $accessToken = Craft::$app->request->headers->get('authorization') ?: Craft::$app->request->headers->get('x-access-token');

            // If "Bearer " is present, strip it to get the token.
            if (StringHelper::startsWith($accessToken, 'Bearer ')) {
                $accessToken = StringHelper::substr($accessToken, 7);
            }

            // If we find one, and it looks like a JWT...
            if ($accessToken && count(explode('.', $accessToken)) === 3) {
                // Attempt to parse the token
                $token = (new Parser())->parse((string) $accessToken);

                // Attempt to verify the token
                $signer = new Sha256();
                $verify = $token->verify($signer, $secretKey);

                // If the token passes verification...
                if ($verify) {
                    // Derive the username from the subject in the token
                    $userName = $token->getClaim('sub');

                    // Look for the user
                    $user = Craft::$app->users->getUserByUsernameOrEmail($userName);

                    // If we don't have a user, but we're allowed to create one...
                    if (!$user && $autoCreateUser && $allowPublicRegistration) {
                        // Create a new user and populate with claims
                        $newUser = new User();
                        $newUser->username = $userName;
                        $newUser->email = $token->getClaim('email');
                        $newUser->firstName = $token->getClaim('given_name') ?: '';
                        $newUser->lastName = $token->getClaim('family_name') ?: '';

                        // Attempt to save the user
                        $newUserSuccess = Craft::$app->getElements()->saveElement($newUser);

                        // If user saved ok...
                        if ($newUserSuccess) {
                            // Assign the user to the default public group
                            Craft::$app->users->assignUserToDefaultGroup($newUser);

                            // Look for a picture in the claim
                            $picture = $token->getClaim('picture');

                            // If there is a picture...
                            if ($picture) {
                                // Create a guzzel client
                                $guzzle = Craft::createGuzzleClient();

                                // Attempt to fetch the image
                                $imageUpload = $guzzle->get($picture);

                                // Derive the file extension from the content type
                                $ext = self::$plugin->jWT->mime2ext($imageUpload->getHeader('Content-Type'));

                                // Make a filename from the username, and add some randomness
                                $fileName = $userName . StringHelper::randomString() . '.' . $ext;
                                $tempFile = Craft::$app->path->getTempAssetUploadsPath() . '/' . $fileName;

                                // Fetch it again, this time saving it to a temp file
                                $imageUpload = $guzzle->get($picture, ['save_to' => $tempFile]);

                                // Save the tempfile to the user’s account as profile image
                                Craft::$app->getUsers()->saveUserPhoto($tempFile, $newUser, $fileName);
                            }

                            // Switch our unfound user to our newly created user
                            $user = $newUser;
                        } else {
                            return;
                        }
                    } else {
                        return;
                    }

                    // Attempt to login as the user we have found or created
                    Craft::$app->user->loginByUserId($user->id);
                }
            }

            return;
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
