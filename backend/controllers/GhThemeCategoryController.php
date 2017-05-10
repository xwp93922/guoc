<?php

namespace backend\controllers;

use Yii;
use common\models\GhThemeCategory;
use common\models\searchs\GhThemeCategorySearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\helpers\DataHelper;
use yii\filters\AccessControl;

/**
 * GhThemeCategoryController implements the CRUD actions for GhThemeCategory model.
 */
class GhThemeCategoryController extends Controller
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
     * Lists all GhThemeCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GhThemeCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $statusMap = DataHelper::getGeneralStatus();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Displays a single GhThemeCategory model.
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
     * Creates a new GhThemeCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GhThemeCategory();
        $model->sort_val = 10;
        
        $statusMap = DataHelper::getGeneralStatus();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Updates an existing GhThemeCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        $statusMap = DataHelper::getGeneralStatus();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Deletes an existing GhThemeCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->necessary == 0)
        {
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the GhThemeCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GhThemeCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GhThemeCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
