<?php

namespace backend\controllers;

use Yii;
use common\models\CmsAboutTimeline;
use yii\data\ActiveDataProvider;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\models\CmsPageAbout;
use common\helpers\DataHelper;
use backend\helpers\SiteHelper;
use yii\filters\AccessControl;

/**
 * AboutTimelineController implements the CRUD actions for CmsAboutTimeline model.
 */
class AboutTimelineController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete','save', 'upload'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    
    public function actions()
    {
        $site_id = SiteHelper::getSiteId();
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    //"imageUrlPrefix"  => "http://www.baidu.com",//图片访问路径前缀
                    "imagePathFormat" => "/uploads/{$site_id}/ueditor/images/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => Yii::getAlias("@webroot"),
                ],
            ]
        ];
    }

    /**
     * Lists all CmsAboutTimeline models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        if (!isset($_REQUEST['about_id']))
        {
            throw new NotFoundHttpException('404');
        }
        $about = CmsPageAbout::findOne($_REQUEST['about_id']);
        if (!is_object($about))
        {
            throw new NotFoundHttpException('404');
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => CmsAboutTimeline::find()->where(['about_id'=>$_REQUEST['about_id']]),
        ]);
        $statusMap = DataHelper::getGeneralStatus();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'statusMap' => $statusMap,
            'about_id' => $about->id
        ]);
    }

    /**
     * Displays a single CmsAboutTimeline model.
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
     * Creates a new CmsAboutTimeline model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!isset($_REQUEST['about_id']))
        {
            throw new NotFoundHttpException('404');
        }
        $about = CmsPageAbout::findOne($_REQUEST['about_id']);
        if (!is_object($about))
        {
            throw new NotFoundHttpException('404');
        }
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $model = new CmsAboutTimeline();
        $model->site_id = $site_id;
        $model->lang_id = $lang_id;
        $model->about_id = $_REQUEST['about_id'];
        $statusMap = DataHelper::getGeneralStatus();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index','about_id'=>$model->about_id]);
        }
        return $this->render('create', [
            'model' => $model,
            'statusMap' => $statusMap,
        ]);
    }

    /**
     * Updates an existing CmsAboutTimeline model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $statusMap = DataHelper::getGeneralStatus();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index','about_id'=>$model->about_id]);
        }
        return $this->render('update', [
            'model' => $model,
            'statusMap' => $statusMap,
        ]);
    }
    

    public function actionSave()
    {
        $request = \Yii::$app->request;
        $id = $request->post('id','');
        $about_id = $request->post('about_id','');
        $content = $request->post('content','');
        $date = $request->post('date','');
        
        if (!empty($id))
        {
            $model = $this->findModel($id);
        }
        else
        {
            $site_id = \Yii::$app->params['site_id'];
            $lang_id = \Yii::$app->params['lang_id'];
            
            $model = new CmsAboutTimeline();
            $model->site_id = $site_id;
            $model->lang_id = $lang_id;
            $model->about_id = $about_id;
        }
        $model->content = $content;
        $model->date = $date;
    
        if ($model->save()) {
            return json_encode(['c'=>0]);
        }
        else
        {
            return json_encode(['c'=>1003,'msg'=>json_encode($model->getFirstErrors())]);
        }
    }

    /**
     * Deletes an existing CmsAboutTimeline model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        $request = \Yii::$app->request;
        $id = $request->post('id','');
        if (($model = CmsAboutTimeline::findOne($id)) !== null) {
            $model->delete();
            return json_encode(['c'=>0]);
        }
        else
        {
            return json_encode(['c'=>1002,'msg'=>\Yii::t('app', 'Error Params')]);
        }
    }

    /**
     * Finds the CmsAboutTimeline model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsAboutTimeline the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsAboutTimeline::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
