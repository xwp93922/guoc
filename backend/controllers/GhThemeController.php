<?php

namespace backend\controllers;

use Yii;
use common\models\GhTheme;
use common\models\searchs\GhThemeSearch;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\helpers\DataHelper;
use common\helpers\CacheHelper;
use common\helpers\CategoryHelper;
use common\helpers\UtilHelper;
use yii\web\UploadedFile;
use backend\helpers\SiteHelper;
use yii\filters\AccessControl;

/**
 * GhThemeController implements the CRUD actions for GhTheme model.
 */
class GhThemeController extends Controller
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
     * Lists all GhTheme models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GhThemeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $statusMap = DataHelper::getGeneralStatus();
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'statusMap' => $statusMap,
            'categoryMap'=>CategoryHelper::getThemeCategoryMap()
        ]);
    }

    /**
     * Displays a single GhTheme model.
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
     * Creates a new GhTheme model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GhTheme();
        $model->sort_val = 10;

        $statusMap = DataHelper::getGeneralStatus();
        if (Yii::$app->request->isPost) {
            $model->image_pc_file = UploadedFile::getInstance($model, 'image_pc_file');
            if (($file = $model->uploadImagePc(0))!=false) {
                $model->image_pc = $file['src'];
            }
            $model->image_pad_file = UploadedFile::getInstance($model, 'image_pad_file');
            if (($file = $model->uploadImagePad(0))!=false) {
                $model->image_pad = $file['src'];
            }
            $model->image_phone_file = UploadedFile::getInstance($model, 'image_phone_file');
            if (($file = $model->uploadImagePhone(0))!=false) {
                $model->image_phone = $file['src'];
            }
            $model->image_addon_file = UploadedFile::getInstance($model, 'image_addon_file');
            if (($file = $model->uploadImageAddon(0))!=false) {
                $model->image_addon = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()))
            {
                if (count($_POST['GhTheme']['features']) > 0)
                {
                    $model->features = implode(',', $_POST['GhTheme']['features']);
                }
                if (count($_POST['GhTheme']['home_features']) > 0)
                {
                	$model->home_features = implode(',', $_POST['GhTheme']['home_features']);
                }
                if ($model->save())
                {
                    CacheHelper::deleteCache('gh_theme');
                    return $this->redirect(['index']);
                }
                
            }
        }
        return $this->render('create', [
            'model' => $model,
            'statusMap' => $statusMap,
            'categoryMap'=>CategoryHelper::getThemeCategoryMap()
        ]);
    }

    /**
     * Updates an existing GhTheme model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $statusMap = DataHelper::getGeneralStatus();
        
        if (Yii::$app->request->isPost) {
            $model->image_pc_file = UploadedFile::getInstance($model, 'image_pc_file');
            if (($file = $model->uploadImagePc(0))!=false) {
                if (strpos($model->image_pc, 'default') === false)
                {
                    UtilHelper::DeleteImg($model->image_pc);
                }
                $model->image_pc = $file['src'];
            }
            $model->image_pad_file = UploadedFile::getInstance($model, 'image_pad_file');
            if (($file = $model->uploadImagePad(0))!=false) {
                UtilHelper::DeleteImg($model->image_pad);
                $model->image_pad = $file['src'];
            }
            $model->image_phone_file = UploadedFile::getInstance($model, 'image_phone_file');
            if (($file = $model->uploadImagePhone(0))!=false) {
                UtilHelper::DeleteImg($model->image_phone);
                $model->image_phone = $file['src'];
            }
            $model->image_addon_file = UploadedFile::getInstance($model, 'image_addon_file');
            if (($file = $model->uploadImageAddon(0))!=false) {
                UtilHelper::DeleteImg($model->image_addon);
                $model->image_addon = $file['src'];
            }
            
            if ($model->load(Yii::$app->request->post()))
            {
                if (count($_POST['GhTheme']['features']) > 0)
                {
                    $model->features = implode(',', $_POST['GhTheme']['features']);
                }
                if (count($_POST['GhTheme']['home_features']) > 0)
                {
                	$model->home_features = implode(',', $_POST['GhTheme']['home_features']);
                }
                if ($model->save())
                {
                    $theme_id = SiteHelper::getThemeId();
                    if ($theme_id == $model->id)
                    {
                        SiteHelper::setThemeId($theme_id);
                    }
                    CacheHelper::deleteCache('gh_theme');
                    return $this->redirect(['index']);
                }
                
            }
        }
        
        $model->features = explode(',', $model->features);
        $model->home_features = explode(',', $model->home_features);
        return $this->render('update', [
            'model' => $model,	
            'statusMap' => $statusMap,
            'categoryMap'=>CategoryHelper::getThemeCategoryMap()
        ]);
    }

    /**
     * Deletes an existing GhTheme model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->necessary == 0)
        {
            if (strpos($model->image_pc, 'default') === false)
            {
                UtilHelper::DeleteImg($model->image_pc);
            }
            UtilHelper::DeleteImg($model->image_pad);
            UtilHelper::DeleteImg($model->image_phone);
            UtilHelper::DeleteImg($model->image_addon);
            CacheHelper::deleteCache('gh_theme');
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the GhTheme model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GhTheme the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GhTheme::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
