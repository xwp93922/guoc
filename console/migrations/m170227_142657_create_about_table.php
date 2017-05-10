<?php

use yii\db\Migration;

/**
 * Handles the creation of table `about`.
 */
class m170227_142657_create_about_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_page_about', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull()->defaultValue(0),
            
            'company_name'          => $this->string()->notNull(),
            'company_desc'         => $this->string(500)->notNull(),
            'company_slogan'     => $this->string()->null(),
            'company_keywords'      => $this->string()->null(),
            'company_idea'       => $this->string()->null(),
            'company_wish'         => $this->string()->null(),
            'company_culture'            => $this->string()->null(),
            
            'banner' => $this->string()->null(),
            
            'top_banner_name' => $this->string()->null(),
            'top_banner_desc' => $this->string()->null(),
            'homepage_name' => $this->string()->null(),
            'more_btn_name' => $this->string()->null(),
            
            'homepage_left_pic' => $this->string()->null(),
            
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);
        
        $this->createTable('cms_about_team', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull()->defaultValue(0),
            'about_id'       => $this->integer()->notNull(),
            
            'name'          => $this->string()->notNull(),
            'headnode'         => $this->string()->notNull(),
            'profession'     => $this->string()->null(),
            'desc'      => $this->string()->null(),
            
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);
        
        $this->createTable('cms_about_timeline', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull()->defaultValue(0),
            'about_id'       => $this->integer()->notNull(),
            
            'date'          => $this->date()->notNull(),
            'content'         => $this->text()->notNull(),
            
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cms_page_about');
        $this->dropTable('cms_about_team');
        $this->dropTable('cms_about_timeline');
    }
}
