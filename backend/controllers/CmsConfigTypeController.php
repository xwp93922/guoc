<?php

namespace backend\controllers;

use Yii;
use common\models\CmsConfigType;
use common\models\searchs\CmsConfigTypeSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\Controller;
use common\helpers\ThemeHelper;

/**
 * CmsConfigTypeController implements the CRUD actions for CmsConfigType model.
 */
class CmsConfigTypeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all CmsConfigType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsConfigTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CmsConfigType model.
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
     * Creates a new CmsConfigType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CmsConfigType();
		$featureType=ThemeHelper::getFeatureNames();
		$configType=[CmsConfigType::CONFIG_RADIO=>'单选',CmsConfigType::CONFIG_INPUT=>'文本',CmsConfigType::CONFGI_IMAGE=>'单图',CmsConfigType::CONFIG_SELECT=>'下拉框'];
        if ($model->load(Yii::$app->request->post())) {
        	if (count($_POST['CmsConfigType']['feature']) > 0)
        	{
        		$model->feature = implode(',', $_POST['CmsConfigType']['feature']);
        	}
        	if ($model->save()){
        		return $this->redirect(['view', 'id' => $model->id]);
        	}            
        } else {
            return $this->render('create', [
                'model' => $model,
            	'featureType' =>$featureType,
            	'configType'=>$configType
            ]);
        }
    }

    /**
     * Updates an existing CmsConfigType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $featureType=ThemeHelper::getFeatureNames();
        $configType=[CmsConfigType::CONFIG_RADIO=>'单选',CmsConfigType::CONFIG_INPUT=>'文本',CmsConfigType::CONFGI_IMAGE=>'单图'];
    	if ($model->load(Yii::$app->request->post())) {
        	if (count($_POST['CmsConfigType']['feature']) > 0)
        	{
        		$model->feature = implode(',', $_POST['CmsConfigType']['feature']);
        	}
        	if ($model->save()){
        		return $this->redirect(['view', 'id' => $model->id]);
        	} 
    	}           
        $model->feature = explode(',', $model->feature);
       return $this->render('update', [
                'model' => $model,
            	'featureType' =>$featureType,
            	'configType'=>$configType
            ]);
        
    }

    /**
     * Deletes an existing CmsConfigType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsConfigType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsConfigType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsConfigType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
