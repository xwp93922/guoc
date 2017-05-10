<?php

namespace backend\controllers;

use Yii;
use common\models\CmsShareBtn;
use common\models\searchs\CmsShareBtnSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;
use common\helpers\DataHelper;
use common\helpers\CacheHelper;

/**
 * CmsShareBtnController implements the CRUD actions for CmsShareBtn model.
 */
class CmsShareBtnController extends Controller
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
     * Lists all CmsShareBtn models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CmsShareBtnSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusMap' => DataHelper::getGeneralStatus(),
            'typeMap' => DataHelper::getShareBtnTypes(),
        ]);
    }

    /**
     * Displays a single CmsShareBtn model.
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
     * Creates a new CmsShareBtn model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $model = new CmsShareBtn();
        $model->site_id = $site_id;
        $model->lang_id = $lang_id;
        $model->sort_val = 10;
        $model->type = CmsShareBtn::TYPE_LINK;
        
        if (Yii::$app->request->isPost) {
            $model->pic_file = UploadedFile::getInstance($model, 'pic_file');
            if (($file = $model->uploadPic($site_id))!=false) {
                $model->pic = $file['src'];
            }
            $content_file = '';
            $model->content_file = UploadedFile::getInstance($model, 'content_file');
            if (($file = $model->uploadContent($site_id))!=false) {
                $content_file = $file['src'];
            }
        
            if ($model->load(Yii::$app->request->post()))
            {
                if (!empty($content_file))
                {
                    $model->content = $content_file;
                }
                if ($model->save())
                {
                    CacheHelper::deleteCache('share_btns_'.$site_id.'_'.$lang_id);
                    return $this->redirect(['index']);
                }
            }
            else
            {
                print_r($model->errors);
            }
        }
        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Updates an existing CmsShareBtn model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        
        $model = $this->findModel($id);
        if ($model->lang_id != $lang_id)
        {
            throw new NotFoundHttpException('404');
        }

        if (Yii::$app->request->isPost) {
            $model->pic_file = UploadedFile::getInstance($model, 'pic_file');
            if (($file = $model->uploadPic($site_id))!=false) {
                if (strpos($model->pic, 'default') === false)
                {
                    UtilHelper::DeleteImg($model->pic);
                }
                $model->pic = $file['src'];
            }
            $model->content_file = UploadedFile::getInstance($model, 'content_file');
            $content_file = '';
            if (($file = $model->uploadContent($site_id))!=false) {
                if (strpos($model->content, 'default') === false)
                {
                    UtilHelper::DeleteImg($model->content);
                }
                $content_file = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()))
            {
                if (!empty($content_file))
                {
                    $model->content = $content_file;
                }
                if ($model->save())
                {
                    CacheHelper::deleteCache('share_btns_'.$site_id.'_'.$lang_id);
                    return $this->redirect(['index']);
                }
            }
            else
            {
                print_r($model->errors);
            }
        }
        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing CmsShareBtn model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        UtilHelper::DeleteImg($model->pic);
        UtilHelper::DeleteImg($model->content);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsShareBtn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsShareBtn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsShareBtn::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
