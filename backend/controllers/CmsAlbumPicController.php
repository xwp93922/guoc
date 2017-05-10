<?php

namespace backend\controllers;

use Yii;
use common\models\CmsAlbumPic;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use common\models\CmsAlbum;
use common\helpers\DataHelper;
use common\models\UploadForm;
use yii\web\UploadedFile;
use common\helpers\UtilHelper;
use yii\filters\AccessControl;

/**
 * CmsAlbumPicController implements the CRUD actions for CmsAlbumPic model.
 */
class CmsAlbumPicController extends Controller
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
                        'actions' => ['index', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CmsAlbumPic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $site_id = \Yii::$app->params['site_id'];
        $lang_id = \Yii::$app->params['lang_id'];
        if (!isset($_REQUEST['album_id']))
        {
            throw new NotFoundHttpException('404');
        }
        $album = CmsAlbum::findOne($_REQUEST['album_id']);
        if (!is_object($album))
        {
            throw new NotFoundHttpException('404');
        }
        
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if (($files = $model->uploadMultiple($site_id, 'album/images')) != false) {
                $count_pic=0;
                foreach ($files as $f)
                {
                    $album_pic = new CmsAlbumPic();
                    $album_pic->site_id = $site_id;
                    $album_pic->lang_id = $lang_id;
                    $album_pic->album_id = $album->id;
                    $album_pic->name = $f['name'];
                    $album_pic->url = $f['src'];
                    $album_pic->save();
                    $count_pic++;
                }
                $album->count_pic+=$count_pic;
                $album->save();
                return $this->redirect(['cms-album-pic/index','album_id'=>$album->id]);
            }
        }
        
        $album_pics = CmsAlbumPic::find()->where(['album_id'=>$_REQUEST['album_id']])->all();
        $statusMap = DataHelper::getGeneralStatus();

        return $this->render('index', [
            'album_pics' => $album_pics,
            'statusMap' => $statusMap,
            'album' => $album,
            'model' => $model
        ]);
    }

    /**
     * Deletes an existing CmsAlbumPic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        if (!isset($_REQUEST['id']))
        {
            return json_encode(['c'=>-1,'msg'=>\Yii::t('app', 'Error Params')]);
        }
        $model = $this->findModel($_REQUEST['id']);
        if (is_object($model))
        {
            UtilHelper::DeleteImg($model->url);
            CmsAlbum::updateAllCounters(['count_pic'=>-1],'id=:id and count_pic>0',[':id'=>$model->album_id]);
            $model->delete();
            return json_encode(['c'=>0]);
        }
        else
        {
            return json_encode(['c'=>-1,'msg'=>\Yii::t('app', 'Error Params')]);
        }
    }

    /**
     * Finds the CmsAlbumPic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsAlbumPic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsAlbumPic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
