<?php
namespace common\helpers;

use common\models\Article;
use common\models\User;
use common\models\CmsArticle;
use common\models\CmsPage;

class CacheHelper{
    static public function getCache($key)
    {
        $cache = \Yii::$app->cache;
        return $cache->get($key);
    }
    
    static public function setCache($key,$data,$time=0)
    {
        $cache = \Yii::$app->cache;
        $cache->set($key,$data,$time);
    }
    
    static public function deleteCache($key)
    {
        $cache = \Yii::$app->cache;
        $cache->delete($key);
    }
    
    static public function getQueryList($key,$query,$time=0)
    {
        $data = self::getCache($key);
        if (empty($data))
        {
            $data = self::setQueryList($key, $query, $time);
        }
        
        return $data;
    }
    
    static public function getArrayList($key,$array,$time=0)
    {
    	$data = self::getCache($key);
    	if (empty($data))
    	{
    		
    		$data = self::setArrayList($key, $array, $time);
    	}
    
    	return $data;
    }
    
    static public function setArrayList($key,$array,$time=0)
    {
    	self::setCache($key, $array, $time);
    	return $array;
    }
    
    static public function setQueryList($key,$query,$time=0)
    {
        $data = $query->asArray()->all();
        self::setCache($key, $data, $time);
        return $data;
    }
    
    static public function getList($key,$time=0,$primaryKeyName='id')
    {
        $data = self::getCache($key);
        if (empty($data))
        {
            $data = self::setList($key, $time, $primaryKeyName);
        }
        
        return $data;
    }
    
    static public function setList($key,$time=0,$primaryKeyName='id')
    {
        $query = self::getQuery($key);
        $res = $query->asArray()->all();
        $data = [];
        foreach ($res as $r)
        {
            $data[$r[$primaryKeyName]] = $r;
        }
        self::setCache($key, $data, $time);
        return $data;
    }

    static public function removeListByCondition($key,$time=0,$keyName,$keyVal)
    {
        $list = CacheHelper::getCache($key);
        if (!empty($list))
        {
            $count = count($list);
            for ($i=0;$i<$list;$i++)
            {
                if ($list[$i][$keyName]==$keyVal)
                {
                    unset($list[$i]);
                }
            }
            CacheHelper::setCache($key, $list, $time);
        }
    }
    
    static public function getOne($key,$primaryKey,$primaryKeyName='id')
    {
        $data = self::getList($key);
        if (!isset($data[$primaryKey]))
        {
            $data[$primaryKey] = self::setOne($key, $primaryKey, $primaryKeyName);
        }
        return $data[$primaryKey];
    }

    static public function setOne($key,$primaryKey,$primaryKeyName='id')
    {
        $data = self::getList($key);
        $query = self::getQuery($key);
        $data[$primaryKey] = $query->where([$primaryKeyName=>$primaryKey])->asArray()->one();
        self::setCache($key, $data);
        return $data[$primaryKey];
    }
    
    static public function removeOne($key,$primaryKey)
    {
        $data = self::getList($key);
        unset($data[$primaryKey]);
        self::setCache($key, $data);
    }
    
    static public function getQuery($key)
    {
        $query = '';
        switch ($key)
        {
            case 'article':
                $query = CmsArticle::find();
                break;
            case 'user':
                $query = User::find();
                break;
            case 'page':
                $query = CmsPage::find();
                break;
        }
        
        return $query;
    }
}