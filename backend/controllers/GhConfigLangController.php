<?php

namespace backend\controllers;

use Yii;
use common\models\GhConfigLang;
use yii\data\ActiveDataProvider;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;
use yii\filters\AccessControl;

/**
 * GhConfigLangController implements the CRUD actions for GhConfigLang model.
 */
class GhConfigLangController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all GhConfigLang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => GhConfigLang::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GhConfigLang model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new GhConfigLang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GhConfigLang();
        $model->sort_val = 10;

        if (Yii::$app->request->isPost) {
            $model->flag_file = UploadedFile::getInstance($model, 'flag_file');
            if (($file = $model->uploadFlag(0))!=false) {
                $model->flag = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing GhConfigLang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $model->flag_file = UploadedFile::getInstance($model, 'flag_file');
            if (($file = $model->uploadFlag(0))!=false) {
                UtilHelper::DeleteImg($model->flag);
                $model->flag = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                return $this->redirect(['index']);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing GhConfigLang model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->necessary == 0)
        {
            UtilHelper::DeleteImg($model->flag);
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the GhConfigLang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GhConfigLang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GhConfigLang::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
