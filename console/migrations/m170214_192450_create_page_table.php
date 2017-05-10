<?php

use yii\db\Migration;

/**
 * Handles the creation of table `page`.
 */
class m170214_192450_create_page_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_page', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull()->defaultValue(0),

            'name'          => $this->string()->notNull(),
            'cover'         => $this->string(),
            'content'       => $this->text()->notNull(),
            'meta_keywords'         => $this->string(),
            'meta_description'      => $this->string(),

            'status'        => $this->smallInteger()->notNull()->defaultValue(10),

            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);
        
        $this->createTable('cms_page_contact', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull()->defaultValue(0),
        
            'name'          => $this->string(20)->notNull(),
            'phone'         => $this->string(20)->notNull(),
			'telephone'     => $this->string(20)->null(),
            'longitude'     => $this->string(40)->null(),
            'latitude'      => $this->string(40)->null(),
            'address'       => $this->string(200)->notNull(),
            'map_img'       => $this->string()->null(),
            'email'         => $this->string(60)->null(),
            'qq'            => $this->string(20)->null(),
            'zipcode'       => $this->string(20)->null(),
            'wxopenid'      => $this->string()->null(),
            
            'banner' => $this->string()->null(),
            'top_banner_name' => $this->string()->null(),
            'top_banner_desc' => $this->string()->null(),
        
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
        
            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cms_page');
        $this->dropTable('cms_page_contact');
    }
}
