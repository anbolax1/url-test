<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%url}}`.
 */
class m230909_143155_create_url_table extends Migration
{
    public function up()
    {

        $tableOptions = null;
        if($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $tableName = $this->db->tablePrefix . 'url';
        if ($this->db->getTableSchema($tableName, true) !== null) {
            $this->dropTable($tableName);
        }

        $this->createTable('{{%url}}', [
            'id' => $this->primaryKey(),
            'hash_string' => $this->string()->notNull(),
            'url' => $this->string()->notNull(),
            'status_code' => $this->integer()->notNull(),
            'query_count' => $this->integer()->notNull(),
            'error_count' => $this->smallInteger()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%url}}');
    }
}
