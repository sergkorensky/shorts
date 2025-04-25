<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%link}}`.
 */
class m250422_104816_create_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%link}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNull()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        //$this->dropTable('{{%link}}');
        echo "m250422_104816_create_link_table cannot be reverted.\n";
        return false;
    }
}
