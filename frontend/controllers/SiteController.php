<?php
namespace frontend\controllers;

use frontend\components\Controller;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use common\models\CmsBanner;
use common\models\CmsCase;
use common\models\CmsPageAbout;
use common\models\CmsPageContact;
use common\models\CmsArticle;
use common\models\CmsCaseCategory;
use yii\data\Pagination;
use common\models\CmsService;
use common\models\CmsCategory;
use common\models\CmsPage;
use common\models\CmsAlbum;
use common\models\CmsTopBanner;
use common\models\CmsCaseConfig;
use common\models\CmsProductCategory;
use common\models\CmsProductInfo;
use common\helpers\ProductHelper;
use common\models\CmsProductInquiry;
use common\helpers\ThemeHelper;

use common\models\FriendLink;

use common\models\CmsFreecate;
use common\models\CmsJoinInfo;

use common\models\CmsProblem;
use common\models\CmsBrand;
use common\models\CmsBrandCategory;
use common\helpers\InitHelper;
use common\helpers\ExchangeHelper;
use console\controllers\ExchangeController;
use common\models\CmsExchange;
use yii\base\Object;
use common\helpers\UtilHelper;
use common\models\GhSite;
use common\models\CmsAboutTeam;
use common\helpers\DataHelper;
use common\models\TkTotal;
use common\models\TkClassInfo;
use common\helpers\SiteHelper;
use common\models\CmsIndexConfig;
use common\models\CmsConfigType;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $pageType = 1;
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
 public function actionIndex()
    {
        $this->getView()->title = '首页';
        $where = [
            'site_id' => $this->siteId,
            'lang_id' => $this->langId,
            'status' => 10,
        ];
        //获取首页配置信息
    	$features=ThemeHelper::getFeaturesById($this->themeId);
        //获取配置项
        $config_info=ThemeHelper::getConfigType();
        //获取每一个feature对应的配置项
        $configs=[];
        foreach ($features as $val){
        	foreach ($config_info as $key=>$info){
        		if(in_array($val, $info['feature'])){
        			//$info['value']=CmsIndexConfig::find()->where(['config_id'=>$info['id'],'feature'=>$val])->asArray()->one();
        			$info['model']=CmsIndexConfig::find()->where(['config_id'=>$info['id'],'feature'=>$val,'site_id'=>$this->siteId,'lang_id'=>$this->langId])->one();
        			$configs[$val][$info['code']]=$info['model']['value'];	
        		}
        	}
        }
		//承载首页参数集
		$params=[];
        foreach ($features as $feature){
        	switch ($feature){
        		case ThemeHelper::$THEME_FEATURE_BANNER:
        			if(isset($configs[$feature])){
        				$params['banners_config']=$configs[$feature];
        			}       			
        			$banners = CmsBanner::find()->with('images')->where($where)->andWhere(['like','pos',',homepage,'])->orderBy('sort_val asc')->asArray()->all();
        			if(count($banners)==1){
        				$banners=$banners[0];
        			}
        			$params['banners']=$banners;
        			break;
        		case ThemeHelper::$THEME_FEATURE_SERVICE:
        			$query=CmsService::find()->where($where);
        			if(isset($configs[$feature])){
        				$params['services_config']=$configs[$feature];
        				if(isset($configs[$feature]['homepage_count'])){
        					$query->limit($configs[$feature]['homepage_count']);
        				}
        			}      			        			
        			$params['services']=$query->orderBy('sort_val asc')->asArray()->all();
        			break;
        		case ThemeHelper::$THEME_FEATURE_CASE:
        			$query=CmsCase::find()->where($where);
        			if(isset($configs[$feature])){
        				$params['cases_config']=$configs[$feature];
        				if(isset($configs[$feature]['homepage_count'])){
        					$query->limit($configs[$feature]['homepage_count']);
        				}
        			}
        			$params['cases']=$query->asArray()->all();
        			break;
        		case ThemeHelper::$THEME_FEATURE_PRODUCT:
        			if(isset($configs[$feature])){
        				$params['products_config']=$configs[$feature];
        			}
        			$productConfig = ProductHelper::getProductConfigCache($this->siteId, $this->langId);
        			$product_cate=CmsProductCategory::find()->where($where)->limit(5)->asArray()->all();
        			$query=CmsProductInfo::find()->where($where);
        			if(isset($configs[$feature]['homepage_count'])){
        				$query->limit($configs[$feature]['homepage_count']);
        			}
        			$params['products']=$query->orderBy('recommend desc,sort_val asc')->asArray()->all();
        			$params['product_cate']=$product_cate;
        			$params['productConfig']=$productConfig;
        			break;
        		case ThemeHelper::$THEME_FEATURE_ARTICLE:
        			if(isset($configs[$feature])){
        				$params['articles_config']=$configs[$feature];
        			}
        			//DataHelper::getNewArtical($lenght, $where);
        			if(isset($configs[$feature]['homepage_cate'])){
        				if(isset($configs[$feature]['homepage_count'])){
        					$params['articles']=DataHelper::getCateArticle($configs[$feature]['homepage_cate'], $where,$configs[$feature]['homepage_count']);
        				}else{
        					$params['articles']=DataHelper::getCateArticle($configs[$feature]['homepage_cate'], $where);
        				}	
        			}else{
        				$categorys = CmsCategory::find()->where($where)->andWhere(['type'=>'news'])->asArray()->all();
        				$articles = [];
        				if(!empty($categorys)){
        					foreach ($categorys as $category){
        						$article=CmsArticle::find()->where($where)->andWhere(['category_id'=>$category['id']])->asArray()->all();
        						foreach ($article as $val){
        							array_push($articles,$val);
        						}
        					}
        				}
        				if(isset($configs[$feature]['homepage_count'])){
        					if(count($articles)>$configs['feature']['homepage_count']){
        						$articles= array_slice($articles,0,$lenght-1);
        					}
        				}
        				$params['articles']=$articles;
        			}        			
        			break;
        		case ThemeHelper::$THEME_FEATURE_PAGE_CONTACT:
        			if(isset($configs[$feature])){
        				$params['contact_config']=$configs[$feature];
        			}
        			$contact = CmsPageContact::find()->where($where)->asArray()->one();
        			$params['contact']=$contact;
        			break;
        		case ThemeHelper::$THEME_FEATURE_PAGE_ABOUT:
        			if(isset($configs[$feature])){
        				$params['about_config']=$configs[$feature];
        			}
        			if(isset($configs[$feature]['homepage_count'])){
        				$about = CmsPageAbout::find()->with(['teams'])->where($where)->limit($configs[$feature]['homepage_count'])->asArray()->one();
        			}else{
        				$about = CmsPageAbout::find()->with(['teams'])->where($where)->asArray()->one();
        			}
        			
        			$params['about']=$about;
        			break;
        		default:
        			if(isset($configs[$feature])){
        				$params['freaCate_config']=$configs[$feature];
        			}
        			$freeCate=[];
        			$category_free = CmsCategory::find()->where($where)->andWhere(['type'=>'freecate'])->one();
        			if(is_object($category_free)){
        				$freeCate=CmsArticle::find()->where($where)->andWhere(['category_id'=>$category_free->id])->orderBy('sort_val asc')->limit(2)->asArray()->all();
        			}
        			$params['freeCate']=$freeCate;
        			break;        			
        	}	
        }
        
        //不同主题的不同参数
        if($this->mainDatas['cmsSite']['theme_id']==9){
        	$this->layout='main1';
        	//外汇
        	$exchange=CmsExchange::find()->select(['name','code','cash_buy','cash_sale','updated_at'])->limit(6)->asArray()->all();
        	$params['exchange']=$exchange;
        }
        if($this->mainDatas['cmsSite']['theme_id']==8){ 
        	//系统结构
        	$systems=[];
        	$category_system=CmsCategory::find()->where($where)->andWhere(['type'=>'system'])->one();
        	if(is_object($category_system)){
        		$systems=CmsArticle::find()->where($where)->andWhere(['category_id'=>$category_system->id])->orderBy('sort_val asc')->limit(4)->asArray()->all();
        	}
        	//加盟模式
        	$joinModels=[];
        	$category_join=CmsCategory::find()->where($where)->andWhere(['type'=>CmsCategory::CATE_JOIN])->andWhere( ['not', ['parent_id' => 0]])->one();
        	
        	if(is_object( $category_join)){
        		$joinModels=CmsArticle::find()->where($where)->andWhere(['category_id'=>$category_join->id])->orderBy('sort_val asc')->asArray()->all();
        	}
        	//问题解答
        	$questions=[];
        	$page=\Yii::$app->request->get('page',1);
        	$pageSize=3;
        	$category_ques=$category_system=CmsCategory::find()->where($where)->andWhere(['type'=>'question'])->one();
        	$count=CmsArticle::find()->select(['name','left(content,40) as content'])->where($where)->andWhere(['category_id'=>$category_ques->id])->count();        	 
        	$params['questions_count']=ceil(($count/$pageSize));
        	var_dump($category_ques->id);
        	if(is_object( $category_ques)){
        		$questions=CmsArticle::find()->select(['name','left(content,40) as content'])->where($where)->andWhere(['category_id'=>$category_ques->id])->orderBy('sort_val asc')->asArray()->all();
        	}
        	var_dump($questions);
        	if(isset($_GET['page'])){
        		return json_encode($questions);
        	}
        	//加盟信息
        	$join_infos=CmsJoinInfo::find()->where($where)->orderBy('created_at desc')->asArray()->all();
        	//品牌形象
        	$brand_list=CmsCategory::find()->where($where)->andWhere(['type'=>CmsCategory::CATE_BRAND])->andWhere( ['not', ['parent_id' => 0]])->asArray()->all();
        	$params['systems']=$systems;
        	$params['joinModels']=$joinModels;
        	$params['questions']=$questions;
        	$params['join_infos']=$join_infos;
        	$params['freeCate']=$freeCate;
        	$params['brand_list']=$brand_list;
        }
        
        if($this->mainDatas['cmsSite']['theme_id']==10){
        	$params['Spikes']=TkTotal::find()->orderBy('Sales_num desc')->limit(6)->asArray()->all();//领券秒杀
        	$params['News']=TkTotal::find()->orderBy('Quan_time desc')->limit(8)->asArray()->all();//新品上线
        	$params['Hots']=TkTotal::find()->orderBy('Quan_surplus asc')->limit(8)->asArray()->all();//热门商品
        	$params['Likes']=TkTotal::find()->orderBy('Quan_price desc')->limit(8)->asArray()->all();//猜你喜欢
        }
        $params['mainDatas']=$this->mainDatas;
        //var_dump($friend_link);die;
        //var_dump($banners);exit;
        return $this->render('index', $params);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->getView()->title = '登录';
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        ThemeHelper::frontendCheckAccess('page-about',$this->siteId);
        $this->getView()->title = '关于我们';
        $where = [
            'site_id' => $this->siteId,
            'lang_id' => $this->langId,
            'status' => 10,
        ];
		
        $about = CmsPageAbout::find()->with(['teams','events'])->where($where)->asArray()->one();
        //获取所有子级菜单
        $about_list = CmsPage::find()->where($where)->andWhere(['type'=>CmsPage::TYPE_ABOUT ])->andWhere( ['not', ['parent_id' => 0]])->asArray()->all();
        //根据get获取关于我们单页的子单页
        $now_id=\Yii::$app->request->get('about_id',false);
        if(!$now_id){
        	$about_now=isset($about_list[0])?$about_list[0]:[];
        }else{
        	$about_now = CmsPage::find()->where($where)->andwhere(['type'=>CmsPage::TYPE_ABOUT,'id'=>$now_id])->asArray()->one();
        }
        $recommend=DataHelper::getRecommend(10, $where);       
        return $this->render('about-us-page', [
                    'about' => $about,
        			'about_now'=>$about_now,
        			'about_list'=>$about_list,
        			'recommend'=>$recommend
                ]);
    }
	public function actionTeam(){

		$this->getView()->title = '关于我们';
		$where = [
				'site_id' => $this->siteId,
				'lang_id' => $this->langId,
				'status' => 10,
		];		
		$about = CmsPageAbout::find()->with(['teams','events'])->where($where)->asArray()->one();
		$about_list = CmsPage::find()->where($where)->andWhere(['type'=>CmsPage::TYPE_ABOUT ])->andWhere( ['not', ['parent_id' => 0]])->asArray()->all();
		$recommend=DataHelper::getRecommend(10, $where);
		return $this->render('about-team', [
				'teams'=>$about['teams'],
				'about_list'=>$about_list,
				'recommend'=>$recommend
		]);
	}
    public function actionContact()
    {
        ThemeHelper::frontendCheckAccess('page-contact',$this->siteId);
        $this->getView()->title = '联系我们';
        $where = [
            'site_id' => $this->siteId,
            'lang_id' => $this->langId,
            'status' => 10,
        ];
        $params=[];
        $info = CmsPageContact::find()->where($where)->asArray()->one();
        $params['info']=$info;
        //t00008联系我们 
		if($this->mainDatas['cmsSite']['theme_id']==8){
			$con_id=\Yii::$app->request->get('con_id',false);
			$cate_contact=CmsPage::find()->where($where)->andwhere(['name'=>'联系我们'])->limit(1)->asArray()->all();
			if(empty($cate_contact)){
				exit('请添加联系我们单页');
			}
			$params['about_list']=array_merge($cate_contact,CmsPage::find()->where($where)->andwhere(['parent_id'=>$cate_contact[0]['id']])->asArray()->all())  ;
			if(!$con_id){
				$params['list_now']=isset($params['about_list'][0])?$params['about_list'][0]:[];
			}else{
				$params['list_now']=CmsPage::find()->where(['id'=>$con_id])->asArray()->one();
			}
			$params['articles']=DataHelper::getRecommend(10, $where);
		}
        return $this->render('contact-us-page',$params);
    }

    public function actionExample()
    {
        ThemeHelper::frontendCheckAccess('case',$this->siteId);
        $this->getView()->title = '案例/产品列表';
        $cid = Yii::$app->request->get('cid', 0);
        $page = Yii::$app->request->get('page', 1);
        $pageSize = 8;
        $where = [
            'site_id' => $this->siteId,
            'lang_id' => $this->langId,
            'status' => 10,
        ];

        //案例分类
        $cts = [];
        $caseConfig = CmsCaseConfig::find()->where(['site_id' => $this->siteId,'lang_id' => $this->langId])->one();
        $use_case_category = is_object($caseConfig) ? $caseConfig->use_category:0;
        if ($use_case_category == 1)
        {
            $cts = CmsCaseCategory::find()->where($where)->andWhere(['parent_id' => 0])->asArray()->all();
        }
        //案例
        if($this->mainDatas['cmsSite']['theme_id']==9){
        	if($cid==0){
        		$cid=CmsCaseCategory::find()->select(['id'])->where($where)->andWhere(['parent_id' => 0])->asArray()->one();
        	}	
        }
        $ct_now= CmsCaseCategory::find()->where($where)->andWhere(['id' => $cid])->asArray()->one();
        $andWhere = [];
        if( !empty($cid) ){
        	$andWhere['category_id'] = $cid;
        }
        $count = CmsCase::find()->where($where)->andWhere($andWhere)->count();
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => $pageSize]);

        $page = ($tmp=intval($page))==0? 1:$tmp;
        $cases = CmsCase::find()->with('category')->where($where)->andWhere($andWhere)->offset(($page-1)*$pageSize)->limit($pageSize)->asArray()->all();
        $where['pos'] = 'case';
        $topBanner = CmsTopBanner::find()->where($where)->one();
        
        return $this->render('example-page', [
				'mainDatas' => $this->mainDatas,
                'cts' => $cts, 
                'cid' => $cid,
                'cases' => $cases,
                'pagination' => $pagination,
                'topBanner' => $topBanner,
        		'ct_now' =>$ct_now
            ]);
    }
    
    public function actionExampleDetail()
    {
        ThemeHelper::frontendCheckAccess('case',$this->siteId);
        $id = Yii::$app->request->get('id', false);
        if( $id===false ){
            exit('缺少必要的参数');
        }

        $model = CmsCase::findOne(['id' => $id, 'status' => 10]);
        if( !is_object($model) ){
            exit('案例不存在');
        }
        
        $where = [
            'site_id' => $this->siteId,
            'lang_id' => $this->langId,
            'status' => 10,
        ];
        //案例分类
        $cts = [];
        $caseConfig = CmsCaseConfig::find()->where(['site_id' => $this->siteId,'lang_id' => $this->langId])->one();
        $use_case_category = is_object($caseConfig) ? $caseConfig->use_category:0;
        if ($use_case_category == 1)
        {
        	$cts = CmsCaseCategory::find()->where($where)->andWhere(['parent_id' => 0])->asArray()->all();
        }
        $cts_now=CmsCaseCategory::find()->where($where)->andWhere(['parent_id' => 0,'id'=>$id ])->asArray()->all();
        $preId = CmsCase::find()->where(['<', 'id', $id])->andWhere($where)->max('id');
        $nextId = CmsCase::find()->where(['>', 'id', $id])->andWhere($where)->min('id');

        $preModel = [];
        $nextModel = [];
        if( !empty($preId) ){
            $preModel = CmsCase::findOne($preId);
        }
        if( !empty($nextId) ){
            $nextModel = CmsCase::findOne($nextId);
        }
        
        $where['pos'] = 'case';
        $topBanner = CmsTopBanner::find()->where($where)->one();
        $this->getView()->title = $model->name . ' - 案例/产品详情';
        
        return $this->render('example-detail', ['model' => $model,'cts'=>$cts, 'preModel' => $preModel, 'nextModel' => $nextModel, 'topBanner' => $topBanner]);
    }
    
    public function actionSinglePage()
    {
        ThemeHelper::frontendCheckAccess('page',$this->siteId);
        $id = Yii::$app->request->get('id', false);
        if( $id===false ){
            exit('缺少必要的参数');
        }

        $model = CmsPage::findOne(['id' => $id, 'status' => 10]);
        if( !is_object($model) ){
            exit('案例不存在');
        }
        $this->getView()->title = $model->name . ' - 单页';;
        
        return $this->render('single-page', ['model' => $model]);
    }

    public function actionAlbum()
    {
        ThemeHelper::frontendCheckAccess('cms-album',$this->siteId);
        
        $aid = Yii::$app->request->get('aid', 0);
    
        $where = [
            'id' => $aid,
            'site_id' => $this->siteId,
            'lang_id' => $this->langId,
            'status' => 10,
        ];
        
        $album = CmsAlbum::find()->with(['pics'])->where($where)->one();
        
        unset($where['id']);
        $where['pos'] = 'album';
        $topBanner = CmsTopBanner::find()->where($where)->one();
        
        $this->getView()->title = $album->name . ' - 图册';;
        
        return $this->render('album', [
            'album' => $album,
            'topBanner' => $topBanner,
        ]);
    }
    


    public function actionAlbumList()
    {
        ThemeHelper::frontendCheckAccess('cms-album',$this->siteId);
        $page = Yii::$app->request->get('page', 1);
        $pageSize = 24;
    
        $where = [
            'site_id' => $this->siteId,
            'lang_id' => $this->langId,
            'status' => 10,
        ];
    
        $count = CmsAlbum::find()->where($where)->count();
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => $pageSize]);
    
        $page = ($tmp=intval($page))==0? 1:$tmp;
        $albums = CmsAlbum::find()->where($where)->offset(($page-1)*$pageSize)->limit($pageSize)->asArray()->all();
        
        $where['pos'] = 'album';
        $topBanner = CmsTopBanner::find()->where($where)->one();
        
        $this->getView()->title = '图册列表';;
    
        return $this->render('album-list', [
            'albums' => $albums,
            'pagination' => $pagination,
            'topBanner' => $topBanner,
        ]);
    }

    public function actionList()
    {
    	
    	if($this->mainDatas['cmsSite']['theme_id']==10){
    		$this->getView()->title = '商品列表';
    		$count=[];
    		$cid=\Yii::$app->request->get('cid','');
    		$txt=\Yii::$app->request->get('txt','');
    		$count['all']['id']='';
    		$count['all']['name']='全部优惠';
    		$count['all']['count']=TkTotal::find()->count();
    		$class=TkClassInfo::find()->asArray()->all();
    		foreach ($class as $val){
    			$val['count']=TkTotal::find()->where(['Cid'=>$val['id']])->count();
    			$count[$val['id']]=$val;
    		}
    		$query=TkTotal::find();
    		if($txt){
    			$query->Where(['like','Title',"$txt"]);
    		}
    		if($cid){   			
    			$query->andwhere(['Cid'=>$cid]);
    		}
    		if(isset($_GET['rel'])){
    			$type=SiteHelper::getListClass();
    			$order=$type[$_GET['rel']];
    			$query->orderby(" $order desc");
    		} 
    		$count_page=$query->count();
    		$page=\Yii::$app->request->get('page',1);
    		$pageSize=80;
    		$pagination = new Pagination(['totalCount' => $count_page, 'defaultPageSize' => $pageSize]);
    		$list=$query->offset(($page-1)*$pageSize)->limit($pageSize)->asArray()->all();
    		return $this->render('list-page', [
    				'count' => $count,
    				'lists'=>$list,
    				'pagination'=>$pagination
    		]);
    	}
    	$this->getView()->title = '文章资讯列表';
        $where = [
            'site_id' => $this->siteId,
            'lang_id' => $this->langId,
            'status' => 10,
        ];
        $page=\Yii::$app->request->get('page',1);
        $categoryList =CmsCategory::find()->where($where)->andWhere(['type'=>CmsCategory::CATE_NEWS])->andWhere( ['not', ['parent_id' => 0]])->asArray()->all();
        $cate_now=[];
        $category = '';
        if (isset($_GET['cid']))
        {
            //echo $_GET['cid'];
            $category = CmsCategory::findOne(intval($_GET['cid'], 10));
            $cate_now=CmsCategory::find()->where($where)->andWhere(['id'=>$_GET['cid']])->asArray()->one();
            if (!is_object($category))
            {
                exit('栏目不存在');
            }
            if($cate_now['parent_id']>0){
            	$where['category_id'] = $category->id;
            }            
        }else{
            $cate_now=isset($categoryList[0])?$categoryList[0]:[];
            $category=$cate_now;
            $where['category_id']=isset($cate_now['id'])?$cate_now['id']:'';
        }
        $pageSize = 6;
        $count = CmsArticle::find()->where($where)->count();
        //var_dump($where);
        $list = CmsArticle::find()->where($where)->offset(($page-1)*$pageSize)->limit($pageSize)->asArray()->all();
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => $pageSize]);
        $where = [
            'site_id' => $this->siteId,
            'lang_id' => $this->langId,
            'status' => 10,
        ];
        //获取相关推荐
        $recommendList = ProductHelper::getProductRecommendCache($this->siteId, $this->langId);
        return $this->render('list-page', [
            'category' => $category,
            'list' => $list,
            'categoryList' => $categoryList,
            'pagination' =>$pagination,
            'cate_now' => $cate_now,
            //'list_late' => $list_late,
            'recommendList' => $recommendList,
        ]);
    }

    public function actionNews()
    {
        //echo SiteHelper::getCurrentSiteId();
        $id = Yii::$app->request->get('id', false);
        $where = [
        		'site_id' => $this->siteId,
        		'lang_id' => $this->langId,
        		'status' => 10,
        ];
        if( $id===false ){
            exit('缺少必要的参数');
        }
        if($this->mainDatas['cmsSite']['theme_id']==10){
        	$this->getView()->title = '商品详情';
        	//获取pid
        	$config_id=CmsConfigType::find()->select('id')->where(['code'=>'pid'])->asArray()->one();
        	$pid=CmsIndexConfig::find()->select('value')->where(['config_id'=>$config_id])->andWhere($where)->asArray()->one()['value'];
        	$detail=TkTotal::find()->with('class')->where(['id'=>$id])->asArray()->one();
  			$hots= TkTotal::find()->orderBy('Sales_num desc')->limit(6)->asArray()->all();
  			$recommends= TkTotal::find()->where(['Cid'=>$detail['class']['id']])->orderBy('Sales_num desc')->limit(8)->asArray()->all();
        	return $this->render('news-page', [
				'detail'=>$detail,
        		'hots'	=>$hots,
        		'pid'	=>$pid,	
        		'recommends'=>$recommends	
        	]);
        }
        $news = CmsArticle::findOne(['id' => $id, 'status' => 10]);
        if( !is_object($news) ){
            exit('新闻不存在');
        }

        $news->view_count++;
        $news->save();
        
        $where = [
            'site_id' => $this->siteId,
            'lang_id' => $this->langId,
            'status' => 10,
        ]; 
        $newList=DataHelper::getNewArtical(10, $where);
        $recommendList= DataHelper::getRecommend(10, $where);
        $categoryList =CmsCategory::find()->where($where)->andWhere(['type'=>CmsCategory::CATE_NEWS])->andWhere( ['not', ['parent_id' => 0]])->asArray()->all();
        
        $preNewsId = CmsArticle::find()->where(['<', 'id', $id])->andWhere($where)->max('id');
        $sufNewsId = CmsArticle::find()->where(['>', 'id', $id])->andWhere($where)->min('id');

        $preNews = [];
        $sufNews = [];
        if( !empty($preNewsId) ){
            $preNews = CmsArticle::findOne($preNewsId);
        }
        if( !empty($sufNewsId) ){
            $sufNews = CmsArticle::findOne($sufNewsId);
        }        
        $where['category_id'] = $news->category_id;
        $where['recommend'] = 1;
        //$recommendList = CmsArticle::find()->where($where)->andWhere('id!=:id',[':id'=>$id])->asArray()->all();       
        $recommend_pro= ProductHelper::getProductRecommendCache($this->siteId, $this->langId);
        $category = '';
        if (!empty($news->category_id))
        {
            $category = CmsCategory::findOne($news->category_id);
        }
        $this->getView()->title = $news->name . ' - 文章资讯详情';
        return $this->render('news-page', [
                'news' => $news, 'category'=>$category, 
                'preNews' => $preNews, 'sufNews' => $sufNews,
                'recommendList'=>$recommendList ,
        		'recommend_pro'=>$recommend_pro,
                'categoryList'=>$categoryList,
        		'newsList' =>$newList
        ]);
    }
    
    public function actionProducts()
    {
        ThemeHelper::frontendCheckAccess('cms-product',$this->siteId);
        $this->getView()->title = '商品列表';
        $cid = Yii::$app->request->get('cid', 0);
        $page = Yii::$app->request->get('page', 1);
        $pageSize = 12;
    
        $where = [
            'site_id' => $this->siteId,
            'lang_id' => $this->langId,
            'status' => 10,
        ];
        $cts = [];
        $cts = CmsProductCategory::find()->where($where)->andWhere(['parent_id' => 0])->asArray()->all();
    
    
        //案例
        $andWhere = [];
        if( !empty($cid) ){
            $andWhere['category_id'] = $cid;
        }else{
        	$cid=CmsProductCategory::find()->where($where)->andWhere(['parent_id' => 0])->asArray()->one()['id'];
        	$andWhere['category_id']=CmsProductCategory::find()->where($where)->andWhere(['parent_id' => 0])->asArray()->one()['id'];
        }
        $procate_now=CmsProductCategory::find()->where($where)->andWhere(['id'=>$cid])->asArray()->one();
        $count = CmsProductInfo::find()->where($where)->andWhere($andWhere)->count();
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => $pageSize]);
    
        $page = ($tmp=intval($page))==0? 1:$tmp;
        $products = CmsProductInfo::find()->with('category')->where($where)->andWhere($andWhere)->offset(($page-1)*$pageSize)->limit($pageSize)->asArray()->all();
        $productConfig = ProductHelper::getProductConfigCache($this->siteId, $this->langId);
    	
        $recommendList = ProductHelper::getProductRecommendCache($this->siteId, $this->langId);
        return $this->render('products', [
        	'page'=>$page,
            'cts' => $cts,
        	'procate_now'=>$procate_now,	
            'products' => $products,
            'pagination' => $pagination,
            'productConfig' => $productConfig,
        	'recommendList'	=>$recommendList,
        ]);
    }
    
    public function actionProduct()
    {
        ThemeHelper::frontendCheckAccess('cms-product',$this->siteId);
        $id = Yii::$app->request->get('id', false);
        if( $id===false ){
            exit('缺少必要的参数');
        }
        $where = [
        		'site_id' => $this->siteId,
        		'lang_id' => $this->langId,
        		'status' => 10,
        ];
        $cts = [];
        $cts = CmsProductCategory::find()->where($where)->andWhere(['parent_id' => 0])->asArray()->all();
        $model = ProductHelper::getProductCache($id);
    
        $productConfig = ProductHelper::getProductConfigCache($this->siteId, $this->langId);
    
        $this->getView()->title = $model['product_name'] . ' - 商品详情';
        
        $recommendList = ProductHelper::getProductRecommendCache($this->siteId, $this->langId);
        $contact = CmsPageContact::find()->where($where)->asArray()->one();
        $web=GhSite::find()->select(['host_name'])->where(['id'=>$this->siteId])->asArray()->one();
        return $this->render('product', [
        		'model' => $model, 
        		'productConfig' => $productConfig, 
        		'recommendList'=>$recommendList,
        		'cts'=>$cts,
        		'contact'=>$contact,
        		'web'=>$web
        		]);
    }
    
    public function actionProductSubmit()
    {
        ThemeHelper::frontendCheckAccess('cms-product',$this->siteId);
        $id = Yii::$app->request->post('product_id', false);
        if( $id===false ){
            exit('缺少必要的参数');
        }
        $inquiry = Yii::$app->request->post('inquiry', '');
    
        if (empty($inquiry))
        {
            exit('缺少必要的参数');
        }
        
        $model = new CmsProductInquiry();
        $model->lang_id = $this->langId;
        $model->site_id = $this->siteId;
        $model->product_id = $id;
        $model->inquiry_detail = json_encode($inquiry);
        
        if ($model->save())
        {
			$productConfig = ProductHelper::getProductConfigCache($this->siteId, $this->langId);
			
			Yii::$app->mailer->compose('product-order', [
				'product' => ProductHelper::getProductCache($id),
				'inquiry_detail' => $inquiry]
			)
			->setFrom('cs@gohoc.com')
			->setTo($productConfig['inquiry_email'])
			->setSubject('您收到了一个新的询单')
			->send();
            return $this->redirect(['site/product','id'=>$id]);
        }
        else
        {
            print_r($model->firstErrors);
            exit();
        }
    }
    public function actionLzpage(){
    	$this->getView()->title = '登录注册';
    	$where=['site_id' => $this->siteId,
    			'lang_id' => $this->langId,
    			'status' => 10];
    	 $category = CmsCategory::find()->where($where)->andWhere(['type'=>'login'])->one();
    	$login=CmsArticle::find()->where($where)->andWhere(['category_id'=>$category->id])->asArray()->one();
    	return $this->render('lzpage',['login'=>$login]);
    }
    public function actionChange(){
    	$this->getView()->title = '客户端下载';
    	$cid = Yii::$app->request->get('cid', 0);
    	$where = [
    			'site_id' => $this->siteId,
    			'lang_id' => $this->langId,
    			'status' => 10,
    	];
    	$changes=CmsPage::find()->where($where)->andWhere(['type'=>CmsPage::TYPE_CHANGE])->andWhere( ['not', ['parent_id' => 0]])->asArray()->all();
    	if($cid==0){
    		$change_now=isset($changes[0])?$changes[0]:[];
    	}
    	$change_now=CmsPage::find()->where($where)->andWhere(['type'=>CmsPage::TYPE_CHANGE,'id'=>$cid])->asArray()->one();
    	 if($change_now['parent_id'==0]){
    	 	$change_now=isset($changes[0])?$changes[0]:[];
    	 }    	
    	$exchange=CmsExchange::find()->select(['name','code','cash_buy','cash_sale','updated_at'])->limit(6)->asArray()->all();
    	return $this->render('change',['changes'=>$changes,'change_now'=>$change_now,'exchange'=>$exchange]);
    }
    
    public function actionOnbase(){
    	$this->getView()->title = '商家支持';
    	$cid = Yii::$app->request->get('cut_id', 0);
    	
    	$where = [
    			'site_id' => $this->siteId,
    			'lang_id' => $this->langId,
    			'status' => 10,
    	];
    	if($cid==0){
    		$cid=CmsPage::find()->select(['id'])->where($where)->andWhere(['type'=>CmsPage::TYPE_ONBASE])->andWhere( ['not', ['parent_id' => 0]])->asArray()->one();
    	}
    		$change_now=CmsPage::find()->where(['id'=>$cid])->asArray()->one();
    	$onbases=CmsPage::find()->where($where)->andWhere(['type'=>CmsPage::TYPE_ONBASE])->andWhere( ['not', ['parent_id' => 0]])->asArray()->all();   
    	//var_dump($onbases);die();
    	return $this->render('onbase',['onbases'=>$onbases,'change_now'=>$change_now]);
    }
    
    public function actionCompare(){
    	$this->getView()->title = '代理合作';
    	$cid=\Yii::$app->request->get('cid', 0);
    	$where = [
    			'site_id' => $this->siteId,
    			'lang_id' => $this->langId,
    			'status' => 10,
    	];
    	if($cid==0){
    		$cid=CmsPage::find()->select(['id'])->where($where)->andWhere(['type'=>CmsPage::TYPE_COMPARE])->andWhere( ['not', ['parent_id' => 0]])->asArray()->one();
    	}
    	$compare_now=CmsPage::find()->where(['id'=>$cid])->asArray()->one();
    	$compares=CmsPage::find()->where($where)->andWhere(['type'=>CmsPage::TYPE_COMPARE])->andWhere( ['not', ['parent_id' => 0]])->asArray()->all();
    	$compare_list=CmsPage::find()->where(['parent_id'=>$compare_now['id']])->asArray()->all();
    	$count=count($compare_list);
    	$pageSize=10;
    	$pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => $pageSize]);
    	return $this->render('compare',['compare_now'=>$compare_now,'compares'=>$compares,'compare_list'=>$compare_list,'pagination'=>$pagination]);
    }
    
    public function actionCompareDetail(){
    	$this->getView()->title = '代理合作详情';
    	$cid=\Yii::$app->request->get('cd_id', false);
    	if(!$cid){
    		exit('缺少必要的参数');
    	}
    	$where = [
    			'site_id' => $this->siteId,
    			'lang_id' => $this->langId,
    			'status' => 10,
    	];
    	$Detail_now=CmsPage::find()->where($where)->andWhere(['id'=>$cid])->asArray()->one();
    	if(empty($Detail_now)){
    		exit('改文档不存在');
    	}
    	$compares=CmsPage::find()->where($where)->andWhere(['type'=>CmsPage::TYPE_COMPARE])->andWhere( ['not', ['parent_id' => 0]])->asArray()->all();
    	return $this->render('compare-detail',['compare_now'=>$compare_now,'compares'=>$compares]);
    }
    public function actionSetlang(){
    	$rt=[];
		if(isset($_POST['lang'])){
			$lang=$_POST['lang'];
			if($lang=='ENG'){
				$_SESSION['lang']='zh-CN';
				$_SESSION['lang_id']=1;
			}else if($lang=='简体中文'){
				$_SESSION['lang']='en-us';
				$_SESSION['lang_id']=2;
			}
			$rt = ['c'=>0,'msg'=>'修改成功'];
		}else{
			$rt = ['c'=>1,'msg'=>'修改失败'];
		}
		return json_encode($rt);
    }

    public function actionProblem(){
    	$this->getView()->title = '问题详情';
        $where = [
            'site_id' => $this->siteId,
            'lang_id' => $this->langId,
            'status' => 10,
        ];
        //获取到这个类别下所有的子栏目
        $problem_child=CmsCategory::find()->where($where)->andWhere(['type'=>CmsCategory::CATE_QUESTION])->andWhere( ['not', ['parent_id' => 0]])->asArray()->all();
        
        //获取到这个类别的cat_id，没有获取到cat_id为0
        $problem_now=[];
        $cat_id=yii::$app->request->get('cat_id',false);
		if(!$cat_id){
			$problem_now=isset($problem_child[0])?$problem_child[0]:[];
		}else{
			$problem_now=CmsCategory::find()->where(['id'=>$cat_id])->asArray()->one();
		} 		      
        //获取到问题的列表
        if(isset($problem_now['id'])){
        	$problem_list=CmsArticle::find()->where($where)->andWhere(['category_id'=>$problem_now['id']])->asArray()->all();
        }else{
        	exit('列表错误');
        }
      
        $pageSize = 4;
        $count = count($problem_list);
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => $pageSize]);

        //获取相关推荐
        $recommendList = ProductHelper::getProductRecommendCache($this->siteId, $this->langId);


        return $this->render('all-problems', [
            'problem_child' => $problem_child,
            'problem_list' => $problem_list,
            'pagination' =>$pagination,
            'recommendList' => $recommendList,
        	'problem_now'=>$problem_now	

        ]);
    }

    public function actionProblemPage(){
        $where = [
            'site_id' => $this->siteId,
            'lang_id' => $this->langId,
            'status' => 10,
        ];

        //推荐新闻列表
        $recommend=DataHelper::getRecommend(10, $where);
        //最新文章
        $news_artical=DataHelper::getNewArtical(10,$where);
        $id = Yii::$app->request->get('id', false);
        if( $id===false ){
            exit('缺少必要的参数');
        }
        $where['id'] = $id;

        $info = CmsArticle::find()->where($where)->one();
        if(!is_object($info)){exit('你要查询的问题找不到');}

        $info->view_count++;
        $info->save();

/*        $cookies = Yii::$app->response->cookies;
        $cookies->add([
        'name' => 'name',
        'value' => 'Larry',
    ]);*/
        return $this->render('problem-page', [
            //'category' => $category,
            //'list' => $list,
            'info' => $info,
            'recommend'=>$recommend,
            'newsList'=>$news_artical,

        ]);
    }

 		public function actionBrand(){
      	$this->getView()->title = '品牌详情';
        $where = [
            'site_id' => $this->siteId,
            'lang_id' => $this->langId,
            'status' => 10,
        ];
        $andwhere=[];
        $cat_id=yii::$app->request->get('cat_id',false);
        $list=CmsCategory::find()->where($where)->andWhere(['type'=>CmsCategory::CATE_BRAND])->andWhere( ['not', ['parent_id' => 0]])->asArray()->all();        
        if(!$cat_id){
        	$list_now=isset($list[0])?$list[0]:[];
        	$cat_id=isset($list[0]['id'])?$list[0]['id']:[];
        }else{
        	$list_now=CmsCategory::find()->where(['id'=>$cat_id])->asArray()->one();
        }
        $andwhere['category_id']=$cat_id;
        $list_brand=CmsArticle::find()->where($where)->andWhere($andwhere)->limit(6)->all();
        $count=count($list_brand);
        $pageSize=6;
        $pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => $pageSize]);
        //推荐新闻列表
       	$recommend=DataHelper::getRecommend(10, $where);
        return $this->render('brand-list', [
            //'category' => $category,
           'list' => $list,
        	'list_now'=>$list_now,	
            'brand' =>  $list_brand,
        	'recommend'=>$recommend,
        	'pagination'=>$pagination,	
        ]);   

    }

    public function actionBrandDetail(){
    	$this->getView()->title = '品牌详情';
        $where = [
            'site_id' => $this->siteId,
            'lang_id' => $this->langId,
            'status' => 10,
        ];
        //推荐新闻列表
        $recommend=DataHelper::getRecommend(10, $where);
        //获取子级侧边栏
        $list=CmsCategory::find()->where($where)->andWhere(['type'=>CmsCategory::CATE_BRAND])->andWhere( ['not', ['parent_id' => 0]])->asArray()->all();        
        $id = Yii::$app->request->get('id', false);
        $news = CmsArticle::findOne(['id' => $id, 'status' => 10]);
        if( !is_object($news) ){
        	exit('新闻不存在');
        }
         
        $news->view_count++;
        $news->save();
        if( $id===false ){
            exit('缺少必要的参数');
        }
        $where['id'] = $id;
        $brand_detail = CmsArticle::find()->where($where)->asArray()->one();
        //var_dump($brand_detail);die;
       
        return $this->render('brand-detail', [
            //'category' => $category,
            'list' => $list,
            'brand_detail' => $brand_detail,
        		'recommend'=>$recommend,

        ]); 

    }

    public function actionAdv(){
    	$this->getView()->title = '加盟优势';
    	$where = [
    			'site_id' => $this->siteId,
    			'lang_id' => $this->langId,
    			'status' => 10,
    	];
    	//推荐新闻列表
    	$recommend=DataHelper::getRecommend(10, $where);
    	$category = CmsCategory::find()->where($where)->andWhere(['type'=>'join'])->one();
    	$adv=CmsArticle::find()->where($where)->andWhere(['category_id'=>$category->id])->asArray()->one();
        return $this->render('join-adv',['adv'=>$adv,'category'=>$category,'recommend'=>$recommend]);
    }

    public function actionProfiti(){
    	$this->getView()->title = '利益分析';
    	$where = [
    			'site_id' => $this->siteId,
    			'lang_id' => $this->langId,
    			'status' => 10,
    	];
    	//推荐新闻列表
    	$recommend=DataHelper::getRecommend(10, $where);
    	$category = CmsCategory::find()->where($where)->andWhere(['type'=>CmsCategory::CATE_JOIN])->one();
        return $this->render('join-profiti',['category'=>$category,'recommend'=>$recommend]);
    }

    public function actionStyle(){
    	$this->getView()->title = '加盟方式';
    	$where = [
    			'site_id' => $this->siteId,
    			'lang_id' => $this->langId,
    			'status' => 10,
    	];
    	//推荐新闻列表
    	$recommend=DataHelper::getRecommend(10, $where);
    	//加盟模式
    	$joinModels=[];
    	$category_join=CmsCategory::find()->where($where)->andWhere(['type'=>CmsCategory::CATE_JOIN])->andWhere( ['not', ['parent_id' => 0]])->one();
    	if(is_object( $category_join)){
    		$joinModels=CmsArticle::find()->where($where)->andWhere(['category_id'=>$category_join->id])->orderBy('sort_val asc')->asArray()->all();
    	}
        return $this->render('join-style',['joinStyles'=>$joinModels,'category'=>$category_join,'recommend'=>$recommend]);
    }
	public function actionStyleDetail(){
		$this->getView()->title = '加盟方式';
		$where = [
				'site_id' => $this->siteId,
				'lang_id' => $this->langId,
				'status' => 10,
		];
		//推荐新闻列表
		$recommend=DataHelper::getRecommend(10, $where);
		$category_join=CmsCategory::find()->where($where)->andWhere(['type'=>CmsCategory::CATE_JOIN])->andWhere( ['not', ['parent_id' => 0]])->one();
		$id=\Yii::$app->request->get('id',false);
		if(!$id){
			exit('缺少相关参数');
		}
		$joinStyle=CmsArticle::find()->where(['id'=>$id])->one();
		$joinStyle->view_count++;
		$joinStyle->save();
		return $this->render('style-detail',['joinStyle'=>$joinStyle,'category'=>$category_join,'recommend'=>$recommend]);
	}
	
	public function actionPolicy(){	
		$this->getView()->title = '加盟政策';
		$where = [
            'site_id' => $this->siteId,
            'lang_id' => $this->langId,
            'status' => 10,
        ];
		//推荐新闻列表
		$recommend=DataHelper::getRecommend(10, $where);
		$category = CmsCategory::find()->where($where)->andWhere(['type'=>CmsCategory::CATE_JOIN])->one();
		return $this->render('join-policy',['category'=>$category,'recommend'=>$recommend,]);
	}
	public  function actionShow(){
		$this->getView()->title = '加盟展示';
		$page=\Yii::$app->request->get('page',1);
		$where = [
				'site_id' => $this->siteId,
				'lang_id' => $this->langId,
				'status' => 10,
		];
		//推荐新闻列表
		$recommend=DataHelper::getRecommend(10, $where);
		$category=CmsCategory::find()->where($where)->andWhere(['type'=>'join'])->one();
		$count=CmsService::find()->where($where)->count();
		$pageSize=9;
		$services = CmsService::find()->where($where)->offset(($page-1)*$pageSize)->limit($pageSize)->asArray()->all();
		$pagination = new Pagination(['totalCount' => $count, 'defaultPageSize' => $pageSize]);
		return $this->render('join-show',['about'=>$services,'pagination'=>$pagination,'category'=>$category,'recommend'=>$recommend]);
	}
	
	public function actionShowDetail(){
		$this->getView()->title = '加盟店方式';
		$where = [
				'site_id' => $this->siteId,
				'lang_id' => $this->langId,
				'status' => 10,
		];
		//推荐新闻列表
		$recommend=DataHelper::getRecommend(10, $where);
		$category=CmsCategory::find()->where($where)->andWhere(['type'=>'join'])->one();
		$id=\Yii::$app->request->get('id',false);
		if(!$id){
			exit('缺少相关参数');
		}
		$service=CmsService::find()->where(['id'=>$id])->asArray()->one();
		return $this->render('show-detail',['recommend'=>$recommend,'category'=>$category,'service'=>$service]);
	}
	
	public function actionSignCaptcha()
	{
		$session = Yii::$app->session;
		$session->set('sign-captcha',UtilHelper::captcha());
		return UtilHelper::captcha();
	}
	public function actionInfo(){
		$name=\Yii::$app->request->post('name','');
		$phone=\Yii::$app->request->post('phone','');
		$mail=\Yii::$app->request->post('mail','');
		$txt=\Yii::$app->request->post('txt','');
		$cap=\Yii::$app->request->post('cap','');
		$session = Yii::$app->session;
		if (empty($name) || empty($phone) || empty($mail)||empty($txt))
		{
			return json_encode(['c'=>0,'msg'=>'请完善加盟信息']);
		}
		if ($session->has('sign-captcha'))
		{
			if ($session->get('sign-captcha') != md5($_POST['cap']))
			{
				return json_encode(['c'=>-1,'msg'=>'验证码不正确']);
			}
		}
		$joinInfo=new CmsJoinInfo();
		$joinInfo->name=$name;
		$joinInfo->phone=$phone;
		$joinInfo->mail=$mail;
		$joinInfo->content=$txt;
		$joinInfo->site_id=$this->siteId;
		$joinInfo->lang_id=$this->langId;
		$joinInfo->created_at=time();
		if ($joinInfo->save())
        {   
            return json_encode(['c'=>1,'msg'=>'信息提交成功']);
        }
        else
        {
            return json_encode(['c'=>2,'msg'=>'提交失败，请重试']);
        }
	}


}
