<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cms_footlogo`.
 */
class m170411_021909_create_cms_footlogo_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_footlogo', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cms_footlogo');
    }
}
