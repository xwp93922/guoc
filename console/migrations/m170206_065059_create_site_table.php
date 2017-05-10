<?php

use yii\db\Migration;

/**
 * Handles the creation of table `site`.
 */
class m170206_065059_create_site_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {

        $this->createTable('gh_site', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->defaultValue(0),
            'host_name' => $this->string()->unique(),
            'type' => $this->smallInteger()->notNull()->defaultValue(0),
            'plan_id' => $this->smallInteger()->notNull()->defaultValue(0),
            'plan_created_at' => $this->integer()->defaultValue(0),
            'plan_expired_at' => $this->integer()->defaultValue(0),

            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);

        $this->createTable('cms_site', [
            'id' => $this->primaryKey(),
            'site_id' => $this->integer()->notNull(),
            'lang_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'logo' => $this->string(),
            'footer_logo' => $this->string(),
            'description' => $this->string(),
            'homepage_news_banner' => $this->string(),
            'created_at'    => $this->integer(),
            'updated_at'    => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('gh_site');
        $this->dropTable('cms_site');
    }
}
