<?php

use yii\db\Migration;

/**
 * Handles the creation of table `site_lang`.
 */
class m170207_131511_create_site_lang_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('gh_config_lang', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'name18n' => $this->string()->notNull(),
            'flag' => $this->string()->null(),
            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            'necessary' => $this->smallInteger()->notNull()->defaultValue(0),
        ]);

        //不同的语言可以设置不同的主题
        $this->createTable('cms_site_lang', [
            'id' => $this->primaryKey(),
            'site_id' => $this->integer()->notNull(),
            'lang_id' => $this->integer()->notNull(),
            'theme_id' => $this->integer()->defaultValue(0),
            'name' => $this->string()->notNull(), //显示名称
            'flag' => $this->string()->null(),
            'default' => $this->boolean()->defaultValue(0),
            'status' => $this->integer()->notNull()->defaultValue(10),
            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
        ]);
        
        $this->batchInsert('gh_config_lang', ['name','name18n','necessary'], [
            ['中文','zh-CN',1],
            ['英语','en',1],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('gh_config_lang');
        $this->dropTable('cms_site_lang');
    }
}
