<?php

namespace backend\controllers;

use Yii;
use common\models\CmsUser;
use backend\components\Controller;
use common\models\User;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for CmsUser model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Updates an existing CmsUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $model = User::findOne(\Yii::$app->user->id);
        
        if (Yii::$app->request->isPost) {
            $model->avatar_file = UploadedFile::getInstance($model, 'avatar_file');
            if (($file = $model->uploadAvatar($site_id))!=false) {
                UtilHelper::DeleteImg($model->avatar);
                $model->avatar = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if (!empty($model->newpwd1))
                    {
                        $model->setPassword($model->newpwd1);
                        $model->generateAuthKey();
                    }
                        
                    if ($model->save())
                    {
                        return $this->redirect(['user/update']);
                    }
                    else
                    {
                        print_r($model->errors);
                    }
                }
            }
        }
        
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}
