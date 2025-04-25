<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ip}}`.
 */
class m250422_105204_create_ip_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%ip}}', [
            'id' => $this->primaryKey(),
            'ip' => $this->string()->notNull()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        //$this->dropTable('{{%ip}}');
        echo "m250422_105204_create_ip_table cannot be reverted.\n";
        return false;
    }
}
