<?php
namespace common\core;
/**
 * Created by PhpStorm.
 * User: teavoid
 * Date: 17/3/25
 * Time: 00:35
 */
class SiteObj {
    private $siteId = 0;
    private $siteInfo = 0;
    public function setSiteId($id) {
        $this->siteId = $id;
    }

    public function getSiteId() {
        return $this->siteId;
    }

    public function setSiteInfo($info) {
        $this->siteInfo = $info;
    }

    public function getSiteInfo() {
        return $this->siteInfo;
    }
}