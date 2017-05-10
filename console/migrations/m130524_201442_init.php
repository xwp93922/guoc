<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'nickname' => $this->string(32),
            'ext_type' => $this->string(10),
            'ext_id'        => $this->string(),

            'avatar'        => $this->string(),
            'avatar_key'    => $this->string(),

            'phone' => $this->string(),
            'email' => $this->string(),

            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),

            'auth_key'      => $this->string(32)->notNull(),
            'access_token'  => $this->string(32),

            'type' => $this->integer()->notNull()->defaultValue(0),
            'level' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'last_login_at' => $this->integer()->notNull()->defaultValue(0),
            'last_login_ip' => $this->string(15),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%admin_user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string(),
            'phone' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
