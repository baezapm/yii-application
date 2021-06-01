<?php

namespace api\modules\v1\controllers;

use common\models\User;
use Dersonsena\JWTTools\JWTTools;
use Yii;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class AuthController extends ActiveController
{
    public $modelClass = User::class;

    public function init()
    {
        parent::init();
        Yii::$app->user->enableSession = false;
    }

    public function actionLogin()
    {
        $post = Yii::$app->request->post();
        $user = User::findOne(['username' => $post['username']]);

        if (empty($user)) {
            throw new NotFoundHttpException('User not found');
        }

        if (!$user->validatePassword($post['password'])) {
            throw new ForbiddenHttpException('Wrong username or password');
        }

        $jwtTools = JWTTools::build(Yii::$app->params['jwt']['secret'])
            ->withModel($user, ['id', 'username', 'email']);

        return [
            "access_token" => $jwtTools->getJWT(),
        ];
    }
}