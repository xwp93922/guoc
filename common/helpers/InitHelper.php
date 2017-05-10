<?php

namespace common\helpers;


use yii; 
use common\models\User;
use common\models\GhSite;
use backend;
use common\models\GhConfigLang;
use common\models\CmsNav;
use common\models\CmsInitLog;
use common\models\CmsCategory;
use common\models\CmsSite;
use common\models\GhTheme;
use common\models\CmsTheme;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 16/9/26
 * Time: 22:23
 */
class InitHelper {
    static public function initSiteData($user_id)
    {    	
        
        $gh_site = new GhSite();
        $gh_site->user_id = $user_id;
        //$gh_site->key=UtilHelper::get_order_sn();
        //$gh_site->host_name ='http://demo.bothsite.com?id='.UtilHelper::getRandChar(6) ;
        $gh_site->host_name ='http://'.UtilHelper::getRandChar(6).'.example.com';
        if($gh_site->save())
        {
            $session = \Yii::$app->session;
            $session->set('cms.site_id',$gh_site->id);
            backend\helpers\SiteHelper::setLangId();
            backend\helpers\SiteHelper::setThemeId();
            $lang_id = backend\helpers\SiteHelper::getLangId();
            $theme_id = backend\helpers\SiteHelper::getThemeId();
            self::initThemeData();
            backend\helpers\SiteHelper::setSiteId($user_id);
        }
    }
    
    static public function initThemeData()
    {
        $site_id = backend\helpers\SiteHelper::getSiteId();
        $lang_id = backend\helpers\SiteHelper::getLangId();
        $theme_info = backend\helpers\SiteHelper::getThemeArr();
        $lang_info = backend\helpers\SiteHelper::getLangArr();
        $ghLang = GhConfigLang::findOne($lang_info['lang_id']);
        $initImgUrl = '/uploads/default/';
        if (CmsInitLog::find()->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'theme_code'=>$theme_info['code']])->count() == 0) {
            $now = time();
            switch ($theme_info['code'])
            {
                case 'first':
                    if ($ghLang->name18n == 'zh-CN')
                    {
                        $categoryName = '新闻资讯';
                        $categoryDesc = '新闻资讯';
                        $homepageName = '首页';
                        $caseNamePre = '案例';
                        $companyName = '光合科技';
                        $companyDesc = '光合科技，一家专业的互联网服务公司。';
                        $contactName = '志斌';
                        $contactPhone = '13800000000';
                        $serviceNamePre = '服务';
                        $siteName = '博赛';
                        $siteDesc = '博赛，saas系统。';
                    }
                    elseif ($ghLang->name18n == 'en')
                    {
                        $categoryName = 'News';
                        $categoryDesc = 'News';
                        $homepageName = 'Homepage';
                        $caseNamePre = 'Case ';
                        $companyName = 'Gohoc';
                        $companyDesc = 'Gohoc is a good company.';
                        $contactName = 'Zhi Bin';
                        $contactPhone = '13800000000';
                        $serviceNamePre = 'Service ';
                        $siteName = 'Bothsite';
                        $siteDesc = 'Bothsite，saas system.';
                    }
            
                    $res = self::insert('cms_category', [
                        'lang_id'=>$lang_id,
                        'site_id'=>$site_id,
                        'parent_id' => 0,
                        'name' => $categoryName,
                        'description' => $categoryDesc,
                        'status' => 10,
                        'necessary' => 1,
                        'type'=>'news',
                        'created_at'=>$now,
                        'updated_at'=>$now,
                    ]);
                    if ($res > 0)
                    {
                        $category_id = \Yii::$app->db->getLastInsertID();
                        $navs = [
                            [$lang_id,$site_id,$homepageName,CmsNav::TYPE_HOMEPAGE,0,0,10,0],
                            [$lang_id,$site_id,$categoryName,CmsNav::TYPE_CATEGORY,0,$category_id,10,1],
                        ];
                        self::batchInsert('cms_nav', ['lang_id','site_id','name','type','parent_id','ext_id','status','sort_val'], $navs);
                    }
            
                    $banner = [
                        'lang_id'=>$lang_id,
                        'site_id'=>$site_id,
                        'pos' => ',homepage,',
                        'status' => 10,
                        'necessary' => 1,
                        'created_at'=>$now,
                        'updated_at'=>$now,
                    ];
                    if (self::insert('cms_banner', $banner) > 0)
                    {
                        $banner_id = \Yii::$app->db->getLastInsertID();
                        $banner_pics = [
                            [$banner_id,$initImgUrl.'banner_pic1.jpg','#',10,$now,$now],
                            [$banner_id,$initImgUrl.'banner_pic2.jpg','#',10,$now,$now],
                            [$banner_id,$initImgUrl.'banner_pic3.jpg','#',10,$now,$now],
                            [$banner_id,$initImgUrl.'banner_pic4.jpg','#',10,$now,$now]
                        ];
                        self::batchInsert('cms_banner_pic', ['banner_id','image','link','status','created_at','updated_at'], $banner_pics);
                    }
            
                    self::batchInsert('cms_case', ['lang_id','site_id','category_id','name','summary','image_main','image_node','status','created_at','updated_at'], [
                        [$lang_id,$site_id,0,$caseNamePre.'1',$caseNamePre.'1',$initImgUrl.'case_pic1.png',$initImgUrl.'case_pic1.png',10,$now,$now],
                        [$lang_id,$site_id,0,$caseNamePre.'2',$caseNamePre.'2',$initImgUrl.'case_pic2.png',$initImgUrl.'case_pic2.png',10,$now,$now],
                        [$lang_id,$site_id,0,$caseNamePre.'3',$caseNamePre.'3',$initImgUrl.'case_pic3.png',$initImgUrl.'case_pic3.png',10,$now,$now],
                        [$lang_id,$site_id,0,$caseNamePre.'4',$caseNamePre.'4',$initImgUrl.'case_pic4.png',$initImgUrl.'case_pic4.png',10,$now,$now],
                    ]);
            
                    self::insert('cms_page_about', [
                        'lang_id'=>$lang_id,
                        'site_id'=>$site_id,
                        'company_name'=>$companyName,
                        'company_desc'=>$companyDesc,
                        'status'=>10,
                        'created_at'=>$now,
                        'updated_at'=>$now,
                    ]);
            
                    self::insert('cms_page_contact', [
                        'lang_id'=>$lang_id,
                        'site_id'=>$site_id,
                        'name'=>$contactName,
                        'phone'=>$contactPhone,
                        'longitude'=>'113.944174',
                        'latitude'=> '22.544317',
                        'address'=>'广东省深圳市南山区粤海街道科苑路9号园西工业区',
                        'status'=>10,
                        'created_at'=>$now,
                        'updated_at'=>$now,
                    ]);
            
                    self::batchInsert('cms_service', ['lang_id','site_id','name','description','cover','status','created_at','updated_at'], [
                        [$lang_id,$site_id,$serviceNamePre.'1',$serviceNamePre.'1',$initImgUrl.'service_pic1.png',10,$now,$now],
                        [$lang_id,$site_id,$serviceNamePre.'2',$serviceNamePre.'2',$initImgUrl.'service_pic2.png',10,$now,$now],
                        [$lang_id,$site_id,$serviceNamePre.'3',$serviceNamePre.'3',$initImgUrl.'service_pic3.png',10,$now,$now],
                        [$lang_id,$site_id,$serviceNamePre.'4',$serviceNamePre.'4',$initImgUrl.'service_pic4.png',10,$now,$now],
                    ]);
            
                    self::insert('cms_site', [
                        'lang_id'=>$lang_id,
                        'site_id'=>$site_id,
                        'name'=>$siteName,
                        'logo'=>$initImgUrl.'logo.png',
                        'footer_logo'=>$initImgUrl.'footer_logo.png',
                        'description'=> $siteDesc,
                        'use_case_category'=>0,
                        'created_at'=>$now,
                        'updated_at'=>$now,
                    ]);
            
                    break;
            }
            
            self::insert('cms_init_log', [
                'lang_id'=>$lang_id,
                'site_id'=>$site_id,
                'theme_code'=>$theme_info['code'],
                'created_at'=>$now,
                'updated_at'=>$now,
            ]);
        }
    }
    
    static public function batchInsert($table,$fields,$datas)
    {
        return \Yii::$app->db->createCommand()->batchInsert(
            $table,
            $fields,
            $datas
        )->execute();
    }
    
    static public function insert($table,$row)
    {
        return \Yii::$app->db->createCommand()->insert($table, $row)->execute();
    }
    
    static public function initDefalutData($site_id,$hostname,$lang_id=1){
    	$now = time();
    	if(	CmsSite::find()->where(['id'=>$site_id,'lang_id'=>$lang_id])->count()==0){
    		if(GhSite::find()->where(['id'=>$site_id])->count()==0){
	    		self::batchInsert('gh_site', [ 'id','user_id', 'host_name', 'type', 'plan_id', 'plan_created_at', 'plan_expired_at', 'status', 'created_at', 'updated_at'],
	    		[
	    			[$site_id,$site_id, $hostname, 2, 1, 0, 0, 10, $now, $now]
	    		]);
    		}
    		self::batchInsert('cms_site',['site_id','lang_id','theme_id','name','logo','footer_logo','description','created_at','updated_at'],
    		[
    			[$site_id,$lang_id,$site_id,'博赛智能模板','/uploads/default/logo.png','/uploads/default/footer_logo.png','博赛智能建站SAAS',$now,$now],
    		]);
    		if(CmsTheme::find()->where(['id'=>$site_id])->count()==0){
	    		self::batchInsert('cms_theme',[ 'site_id', 'theme_id', 'status', 'sort_val', 'created_at', 'updated_at'],
	    		[
	    			[$site_id, $site_id, '11', '10', $now,$now],
	    		]);
    		}
    		if(GhTheme::find()->where(['id'=>$site_id])->count()==0){

	    		self::batchInsert('gh_theme', ['id','category_id', 'name', 'code', 'desc', 'price_origin', 'price', 'features', 'image_pc', 'image_pad', 'image_phone', 'image_addon', 'type', 'necessary', 'status', 'sort_val', 'created_at', 'updated_at'],
	    		[
	    			[$site_id,'1', '博赛智能建站模板', 't' . str_pad($site_id,5,"0",STR_PAD_LEFT), '光合科技', '0.00', '0.00', '1001,2001,3001,4001,4002,4003,5001,6001,7001,8001,9001,10001', '/uploads/0/theme/images/20170316/a0b5ddc8-cbf6-60fc-ecd9-0c8d0203e06f.png', NULL, NULL, NULL, '0', '1', '10', '100', $now, $now]			
	    		]);
    		}
    		self::batchInsert('cms_page_contact',[ 'lang_id', 'site_id', 'name', 'phone', 'longitude', 'latitude', 'address', 'email', 'qq', 'zipcode', 'wxopenid', 'banner', 'status', 'sort_val', 'created_at', 'updated_at'],
    		[
    			[$lang_id, $site_id, '博赛智能建站模板', '13800000000', '113.944174', '22.544317', '广东省深圳市南山区粤海街道科苑路9号园西工业区', '123456@qq.com', '123456', '000000', '/uploads/1/contact/images/20170316/277b0165-80e7-6803-cb4b-1ec5866c92a1.png', '/uploads/1/contact/images/20170317/89e9bb2f-e48f-7353-49ba-0b0c8c20cf06.png', 10, 100,$now,$now]    							
    		]);  
    	}
    	if(User::find()->where(["like","username","admin"])->count()==0){
    		self::batchInsert('user',['id','username', 'nickname', 'ext_type', 'ext_id', 'avatar', 'avatar_key', 'phone', 'email', 'password_hash', 'password_reset_token', 'auth_key', 'access_token', 'type', 'level', 'status', 'last_login_at', 'last_login_ip', 'created_at', 'updated_at'],
    				[
    						[$site_id,'admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '$2y$13$rL6n0LGUiUhyXA9kzZ2tRusO86eOax8lRFfpR6Bdwyr/FHk2zNQfS', NULL, '7E5TN0SIgAbyxHht5We6Ut18LYb3q9Cf', NULL, 0, 0, 10, 0, NULL, 1490838461, 1490838461],
    				]);
    	} 
    	$where = [
    			'site_id' => $site_id,
    			'lang_id' => $lang_id,
    			'status' => 10,
    	];
    	if(CmsCategory::find()->where($where)->andwhere(['type'=>'news','necessary'=>1])->count()==0){
    		self::batchInsert('cms_category',['lang_id','site_id','parent_id','name','description','status','necessary','type','created_at','updated_at'],
    				[
    						[$lang_id,$site_id,0,'新闻资讯','新闻资讯',10,1,'news',$now,$now]  						
    				]);
    	}
    }
    
    static public function initLzpage($site_id,$lang_id=1){
    	$now = time();
    	$where = [
    			'site_id' => $site_id,
    			'lang_id' => $lang_id,
    			'status' => 10,
    	];
	    if(CmsCategory::find()->where($where)->andwhere(['type'=>'login','necessary'=>1])->count()==0){
	    		self::batchInsert('cms_category',['lang_id','site_id','parent_id','name','description','status','necessary','type','created_at','updated_at'],
	    				[
	    						[$lang_id,$site_id,0,'登录注册','登录注册',10,1,'login',$now,$now]  						
	    				]);
	    }
    }
}