<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product`.
 */
class m170319_032540_create_product_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_product_config', [
            'id' => $this->primaryKey(),
            'lang_id' => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull(),
            'product_field' => $this->text()->notNull(),
            'product_order_btn' => $this->string(40)->null(),
            'product_detail_title' => $this->string(60)->null(),
            'product_detail_more_title' => $this->string(60)->null(),
            'top_banner' => $this->string()->null(),
            'top_banner_name' => $this->string()->null(),
            'top_banner_desc' => $this->string()->null(),
            'homepage_name' => $this->string()->null(),
            'homepage_desc' => $this->string()->null(),
            'more_btn_name' => $this->string()->null(),
            'inquiry_title' => $this->string()->null(),
            'inquiry_field' => $this->text()->notNull(),
            'inquiry_email' => $this->string()->notNull(),
            'inquiry_submit' => $this->string()->null(),
            'blank_error' => $this->string()->null(),
            'mobile_error' => $this->string()->null(),
            'email_error' => $this->string()->null(),
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at'    => $this->integer(),
            'updated_at'    => $this->integer(),
        ]);
        $this->createTable('cms_product_category', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer()->defaultValue(0)->notNull(),

            'name'          => $this->string()->notNull(),
            'description'   => $this->string()->notNull(),
            'image_main' => $this->string(),
            'image_node' => $this->string(),

            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at'    => $this->integer(),
            'updated_at'    => $this->integer(),
        ]);
        $this->createTable('cms_product_info', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull(),
            'category_id'       => $this->integer()->notNull(),
            'product_name' => $this->string()->notNull(),
            'product_info' => $this->text()->notNull(),
            'product_cover' => $this->string()->notNull(),
            'product_content' => $this->text()->notNull(),
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            'recommend'     => $this->smallInteger()->notNull()->defaultValue(0),
            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            'created_at'    => $this->integer(),
            'updated_at'    => $this->integer(),
        ]);
        $this->createTable('cms_product_sku', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull(),
            'product_id'       => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'value' => $this->string()->notNull(),
            'pic' => $this->string()->notNull(),
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            'created_at'    => $this->integer(),
            'updated_at'    => $this->integer(),
        ]);
        $this->createTable('cms_product_pic', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull(),
            'product_id'       => $this->integer()->notNull(),
            'sku_id' => $this->integer()->null(),
            'image' => $this->string()->notNull(),
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            'created_at'    => $this->integer(),
            'updated_at'    => $this->integer(),
        ]);
        $this->createTable('cms_product_inquiry', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull(),
            'product_id'       => $this->integer()->notNull(),
            'inquiry_detail' => $this->text()->notNull(),
            'created_at'    => $this->integer(),
            'updated_at'    => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cms_product_config');
        $this->dropTable('cms_product_category');
        $this->dropTable('cms_product_info');
        $this->dropTable('cms_product_sku');
        $this->dropTable('cms_product_pic');
        $this->dropTable('cms_product_inquiry');
    }
}
