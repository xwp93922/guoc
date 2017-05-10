<?php

namespace backend\controllers;

use Yii;
use common\models\CmsIndexConfig;
use common\models\searchs\CmsIndexConfigSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\ThemeHelper;
use common\models\CmsConfigType;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\helpers\DataHelper;
use common\helpers\CategoryHelper;
/**
 * CmsIndexConfigController implements the CRUD actions for CmsIndexConfig model.
 */
class CmsIndexConfigController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'upload'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CmsIndexConfig models.
     * @return mixed
     */
    public function actionIndex()
    {
    	
    	$site_id = \Yii::$app->params['site_id'];
    	$lang_id = \Yii::$app->params['lang_id'];
        $searchModel = new CmsIndexConfigSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $categoryOptions = CategoryHelper::getCategoryOptions($site_id,$lang_id);
        $model = new CmsIndexConfig();
        $features=ThemeHelper::getFeatures('home_features');
        //获取配置项
        $config_info=ThemeHelper::getConfigType();
        //获取每一个feature对应的配置项
        $configs=[];
        foreach ($features as $val){
        	foreach ($config_info as $key=>$info){
        		if(in_array($val, $info['feature'])){
        			//$info['value']=CmsIndexConfig::find()->where(['config_id'=>$info['id'],'feature'=>$val])->asArray()->one();
        			$info['model']=CmsIndexConfig::find()->where(['config_id'=>$info['id'],'feature'=>$val,'site_id'=>$site_id,'lang_id'=>$lang_id])->one();
        			$configs[$val][$key]=$info;	
        		}
        	}
        }
        //var_dump($configs);
   		//var_dump($configs['10002'][4]['model']->value);die();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'categoryOptions'=>$categoryOptions,	
        	'features' =>$features,
        	'configs'=>$configs	,
        	'model' =>$model,
        	'site_id'=>$site_id	
        ]);
    }

    /**
     * Displays a single CmsIndexConfig model.
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
     * Creates a new CmsIndexConfig model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	$type='';
    	$site_id = \Yii::$app->params['site_id'];
    	$lang_id = \Yii::$app->params['lang_id'];
    	$searchModel = new CmsIndexConfigSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	$categoryOptions = CategoryHelper::getCategoryOptions($site_id,$lang_id);
    	$features=ThemeHelper::getFeatures('home_features');
        $model = new CmsIndexConfig();        
        $model->site_id = $site_id;
        $model->lang_id = $lang_id;
        $model->config_id = $_POST['config_id'];
        
        $model->image = UploadedFile::getInstance($model, 'image');
        if(!isset($_POST['type'])){
        	if (($file = $model->uploadImage($site_id))!=false) {
        		$type=1;
        		$model->value=$file['src'];
        	}else{
        		$type=1;
        		if(isset($_POST['CmsIndexConfig']['value'])){
        			$model->value = $_POST['CmsIndexConfig']['value'];
        		}else{
        			$configs=DataHelper::getFeatureInfos($site_id, $lang_id);
        			return $this->render('index', [
        					'categoryOptions'=>$categoryOptions,
        					'features' =>$features,
        					'configs'=>$configs	,
        					'model' =>$model
        			]);
        		}
        	}
        }else{
        	$model->value=$_POST['value'];
        }
        
        $model->status=10;
        $model->feature=$_POST['feature'];
       /*  foreach ($model as $key => $value) {
        	$value = (is_array($value) || is_object($value)) ? std_class_object_to_array($value) : $value;
        	$array[$key] = $value;
        }
        return json_encode($array); */
        $id=CmsIndexConfig::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'config_id'=>$model->config_id])->one();
       if(CmsIndexConfig::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'config_id'=>$model->config_id])->count()==0){
	        if($model->save()){
	        	if($type==1){
	        		$configs=DataHelper::getFeatureInfos($site_id, $lang_id);
	        		return $this->render('index', [
	        			'categoryOptions'=>$categoryOptions,
			        	'features' =>$features,
			        	'configs'=>$configs	,
			        	'model' =>$model	
			        ]);
	        	}	        	
	        	return json_encode(['c'=>0,'config_id'=>$model->id]);	        	
	        }else{
	        	if($type==1){
	        		$configs=DataHelper::getFeatureInfos($site_id, $lang_id);
	        		return $this->render('index', [
	        				'categoryOptions'=>$categoryOptions,
	        				'features' =>$features,
	        				'configs'=>$configs	,
	        				'model' =>$model
	        		]);
	        	}
	        	return json_encode(['c'=>1,'msg'=>'配置添加错误']);
	        }
       }else{
       		if(CmsIndexConfig::updateAll(['value'=>$model->value,'feature'=>$model->feature],['id'=>$id->id])){
       			if($type==1){
       				$configs=DataHelper::getFeatureInfos($site_id, $lang_id);
       				return $this->render('index', [
       						'categoryOptions'=>$categoryOptions,
       						'features' =>$features,
       						'configs'=>$configs	,
       						'model' =>$model
       				]);
       			}
       			return json_encode(['c'=>0,'msg'=>'配置修改成功']);
       		}else{
       			if($type==1){
       				$configs=DataHelper::getFeatureInfos($site_id, $lang_id);
	        		return $this->render('index', [
	        			'categoryOptions'=>$categoryOptions,
			        	'features' =>$features,
			        	'configs'=>$configs	,
			        	'model' =>$model	
			        ]);
	        	}
       			return json_encode(['c'=>1,'msg'=>'配置修改错误']);
       		}
       		
       		
       }
    }

    /**
     * Updates an existing CmsIndexConfig model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CmsIndexConfig model.
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
     * Finds the CmsIndexConfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsIndexConfig the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsIndexConfig::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
