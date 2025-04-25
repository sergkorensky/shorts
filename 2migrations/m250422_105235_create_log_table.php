<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%log}}`.
 */
class m250422_105235_create_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%log}}', [
            'link_id' => $this->Integer()->notNull(),
  	        'ip_id' => $this->Integer()->notNull(),
             'count' =>  $this->Integer()->defaultValue(1), 
        ]);

        $this->addPrimaryKey ('pk_log', '{{%log}}', ['link_id', 'ip_id'] );

$this->addForeignKey('fk_log_link','{{%log}}',
 'link_id', '{{%link}}', 'id', 'CASCADE', 'NO ACTION');

$this->addForeignKey('fk_log_ip','{{%log}}',
 'ip_id', '{{%ip}}', 'id', 'CASCADE', 'NO ACTION');
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        //$this->dropTable('{{%log}}');        
        echo "m250422_105235_create_log_table cannot be reverted.\n";
        return false;
    }
}
