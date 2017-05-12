<?php
namespace common\helpers;

use common\models\CmsNav;
use common\helpers\DataHelper;
use yii\helpers\Url;
use common\models\CmsCategory;
use backend;
use common\models\CmsProductCategory;
use common\models\CmsPage;

/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/2/10
 * Time: 10:38
 */
class NavHelper
{
    static public function getNavsHtml($navs,$navTypeNames)
    {
        $html = '';
        foreach ($navs as $n)
        {
            if ($n['type'] == CmsNav::TYPE_CATEGORY_SUB)
            {
                $categorys = CmsCategory::find()->where(['parent_id'=>$n['ext_id'],'status'=>CmsCategory::STATUS_ACTIVE])->orderBy('sort_val asc')->all();
                $html .= '<li class="nav-li sub-category" type="'.$n['type'].'" rel="'.$n['id'].'" name="'.$n['name'].'" ext_id="'.$n['ext_id'].'" url="'.$n['ext_content'].'">';                    
                $navTypeName = DataHelper::getValue($navTypeNames, $n['type']);
                foreach ($categorys as $c)
                {
                    $html .= '<a href="javascript:;"><span class="name">'.$c->name.'</span><span class="text-gray">-'.$navTypeName.'</span></a>';
                }
                $html .= '</li>';
            }
            elseif ($n['type'] == CmsNav::TYPE_PRODUCT_CATEGORY)
            {
                $categorys = CmsProductCategory::find()->where(['site_id'=>$n['site_id'],'lang_id'=>$n['lang_id'],'parent_id'=>$n['ext_id'],'status'=>CmsProductCategory::STATUS_ACTIVE])->orderBy('sort_val asc')->all();
                $html .= '<li class="nav-li sub-category" type="'.$n['type'].'" rel="'.$n['id'].'" name="'.$n['name'].'" ext_id="'.$n['ext_id'].'" url="'.$n['ext_content'].'">';
                $navTypeName = DataHelper::getValue($navTypeNames, $n['type']);
                foreach ($categorys as $c)
                {
                    $html .= '<a href="javascript:;"><span class="name">'.$c->name.'</span><span class="text-gray">-'.$navTypeName.'</span></a>';
                }
                $html .= '</li>';
            }
            else 
            {
                $html .= '<li class="nav-li" type="'.$n['type'].'" rel="'.$n['id'].'" name="'.$n['name'].'" ext_id="'.$n['ext_id'].'" url="'.$n['ext_content'].'">';
                $html .= '<a href="javascript:;"><div class="click-layout">&nbsp;</div><span class="name">'.$n['name'].'</span><span class="text-gray">-'.DataHelper::getValue($navTypeNames, $n['type']).'</span><i class="up-down-icon pull-right fa fa-chevron-down"></i></a>';
                $html .= '<div class="box box-solid nav-sub-list">';
                $html .= '<ul class="nav nav-stacked">';
                
                if (isset($n['sub']))
                {
                    $html .= self::getNavsHtml($n['sub'], $navTypeNames);
                }
                
                $html .= '</ul>';
                $html .= '</div>';
                $html .= '</li>';
            }
        }
        return $html;
       
    }
    
    static public function getNavs($site_id,$lang_id,$parent_id=0)
    {
        $navs = CmsNav::find()->with('categroy')->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'parent_id'=>$parent_id])->andWhere('type!='.CmsNav::TYPE_PREDEFINED_LINK)->orderBy('sort_val asc')->asArray()->all();
        $count = count($navs);
        for ($i=0;$i<$count;$i++)
        {
            if (CmsNav::find()->with('categroy')->where(['site_id'=>$site_id,'lang_id'=>$lang_id,'parent_id'=>$navs[$i]['id']])->count()>0)
            {
                $navs[$i]['sub'] = self::getNavs($site_id,$lang_id,$navs[$i]['id']);
            }
        }
    
        return $navs;
    }
    
    static public function deleteNavs($deleteNavIds)
    {
        foreach ($deleteNavIds as $id)
        {
            self::deleteSubNavs($id);
        }
    }
    
    static public function deleteSubNavs($id)
    {
        CmsNav::deleteAll('id=:id',[':id'=>$id]);
        if (CmsNav::find()->where(['parent_id'=>$id])->count() > 0)
        {
            $navs = CmsNav::find()->select(['id'])->where(['parent_id'=>$id])->all();
            foreach ($navs as $n)
            {
                self::deleteSubNavs($n['id']);
            }
        }
    }
    
    static public function saveNavs($navs)
    {
        $count = count($navs);
        for ($i=0;$i<$count;$i++)
        {
            if (empty($navs[$i]['rel']) || strpos($navs[$i]['rel'], 'new'))
            {
                $model = new CmsNav();
                $model->site_id = backend\helpers\SiteHelper::getSiteId();
                $model->lang_id = backend\helpers\SiteHelper::getLangId();
            }
            else
            {
                $model = CmsNav::findOne($navs[$i]['rel']);
            }
    
            if (is_object($model))
            {
                $model->name = $navs[$i]['name'];
                $model->type = $navs[$i]['type'];
                $model->ext_id = $navs[$i]['ext_id'];
                if (isset($navs[$i]['parent_id']))
                {
                    $model->parent_id = $navs[$i]['parent_id'];
                }
                else
                {
                    $model->parent_id = 0;
                }
                if (isset($navs[$i]['url']))
                {
                    $model->ext_content = $navs[$i]['url'];
                }
                else
                {
                    $model->ext_content = '';
                }
                $model->sort_val = $i;
            }
    
            if ($model->save())
            {
                if (isset($navs[$i]['sub']) && is_array($navs[$i]['sub']))
                {
                    $subCount = count($navs[$i]['sub']);
                    for ($j=0;$j<$subCount;$j++)
                    {
                        $navs[$i]['sub'][$j]['parent_id'] = $model->id;
                    }
    
                    self::saveNavs($navs[$i]['sub']);
                }
            }
            else
            {
                print_r($model->errors);
                exit();
            }
        }
    }
    
    static public function getCacheNavs($site_id,$lang_id)
    {
        $navs = CacheHelper::getCache('navs_'.$site_id.'_'.$lang_id);
        if (empty($navs))
        {
            $navs = NavHelper::getNavs($site_id,$lang_id);
            CacheHelper::setCache('navs_'.$site_id.'_'.$lang_id,$navs);
        }
        return $navs;
    }

 static public function getNavUrl($nav){
    	$id=isset(\Yii::$app->session['serial_id'])?\Yii::$app->session['serial_id']:'';
    	if($id){
    		switch ($nav['type'])
    		{
    			case CmsNav::TYPE_HOMEPAGE:
    				return Url::to(['site/index','sname'=>$id]);
    				break;
    			case CmsNav::TYPE_CATEGORY:
    				if($cate=CmsCategory::find()->where(['id'=>$nav['ext_id']])->asArray()->one()){
    					return self::getCateUrl($cate);
    				}else{
    					return Url::to(['site/list','id'=>$nav['ext_id'],'sname'=>$id]);
    				}     				
    				break;
    			case CmsNav::TYPE_PAGE:
    				if($page=CmsPage::find()->where(['name'=>$nav['name']])->asArray()->one()){
    					return PageHelper::getPageUrl($page);
    				}else{
    					return Url::to(['site/single-page','id'=>$nav['ext_id'],'sname'=>$id]);
    				} 
    			case CmsNav::TYPE_PAGE_ABOUT:
    				return Url::to(['site/about','sname'=>$id]);
    				break;
                /*case CmsNav::TYPE_PAGE_PROBLEM:
                    return Url::to(['site/problem','sname'=>$id]);
                    break;
                case CmsNav::TYPE_PAGE_BRAND:
                    return Url::to(['site/brand','sname'=>$id]);
                    break;*/
    			case CmsNav::TYPE_PAGE_CONTACT:
    				return Url::to(['site/contact','sname'=>$id]);
    				break;
    			case CmsNav::TYPE_CUSTOMER_LINK:
    			case CmsNav::TYPE_PREDEFINED_LINK:
    				return $nav['ext_content'];
    				break;
    			case CmsNav::TYPE_CASE:
    				return Url::to(['site/example','sname'=>$id]);
    				break;
    			case CmsNav::TYPE_ALBUM:
    				return Url::to(['site/album-list','sname'=>$id]);
    				break;
    			case CmsNav::TYPE_PRODUCT:
    				return Url::to(['site/products','sname'=>$id]);
    				break;
    		}
    	}else{
    		switch ($nav['type'])
    		{
    			case CmsNav::TYPE_HOMEPAGE:
    				return Url::to(['site/index']);
    				break;
    			case CmsNav::TYPE_CATEGORY:
    				if($cate=CmsCategory::find()->where(['id'=>$nav['ext_id']])->asArray()->one()){
    					return self::getCateUrl($cate);
    				}else{
    					return Url::to(['site/list','id'=>$nav['ext_id']]);
    				}  
    		case CmsNav::TYPE_PAGE:
    				if($page=CmsPage::find()->where(['id'=>$nav['ext_id']])->asArray()->one()){
    					return PageHelper::getPageUrl($page);
    					break;
    				}else{
    					return Url::to(['site/single-page','id'=>$nav['ext_id'],'sname'=>$id]);break;
    				}
    			case CmsNav::TYPE_PAGE_ABOUT:
    				return Url::to(['site/about']);
    				break;
    			case CmsNav::TYPE_PAGE_CONTACT:
    				return Url::to(['site/contact']);
    				break;
    			case CmsNav::TYPE_CUSTOMER_LINK:
    			case CmsNav::TYPE_PREDEFINED_LINK:
    				return $nav['ext_content'];
    				break;
    			case CmsNav::TYPE_CASE:
    				return Url::to(['site/example']);
    				break;
    			case CmsNav::TYPE_ALBUM:
    				return Url::to(['site/album-list']);
    				break;
    			case CmsNav::TYPE_PRODUCT:
    				return Url::to(['site/products']);
    				break;
    		}
    	}
        
        return '';
    }
    static public function getCateUrl($cate){
    	$id=isset(\Yii::$app->session['serial_id'])?\Yii::$app->session['serial_id']:'';
    	if($id){
    		switch ($cate['type'])
    		{
    			case CmsCategory::CATE_JOIN:
    				return Url::to(['site/policy','sname'=>$id]);
    				break;
                case CmsCategory::CATE_QUESTION:
                    return Url::to(['site/problem','sname'=>$id]);
                    break;
                case CmsCategory::CATE_BRAND:
                    return Url::to(['site/brand','sname'=>$id]);
                    break;
                case CmsCategory::CATE_NEWS:
                    return Url::to(['site/list','sname'=>$id]);
                    break;
                case CmsCategory::CATE_QUESTION :
	                return Url::to(['site/problem','sname'=>$id]);
	                break;
    				default:return Url::to(['site/list','sname'=>$id]);

    				break;
    		}
    	}else{
    		switch ($cate['type'])
    		{
    			case CmsCategory::CATE_JOIN:
    				return Url::to(['site/policy']);
    				break;
    			case CmsCategory::CATE_NEWS:
    				return Url::to(['site/list','id'=>$cate['id']]);
    				break;
    			case CmsCategory::CATE_BRAND:
    				return Url::to(['site/brand']);
    				break;
    			case CmsCategory::CATE_NEWS:
    				return Url::to(['site/list']);
    				break;
    			case CmsCategory::CATE_QUESTION :
    				return Url::to(['site/problem']);
    				break;
    			default:return Url::to(['site/list','id'=>$cate['id']]);
    			break;
    		}
    	}
    
    	return '';
    }
    
    static public function isCustomPage( $type ){
        if( $type == 400 ){
            return true;
        }

        return false;
    }

}
