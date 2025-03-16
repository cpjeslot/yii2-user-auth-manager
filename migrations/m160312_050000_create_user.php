<?php

use yii\db\Migration;

/**
 * 
 * @author Chetan Jeslot <cpjeslot@gmail.com>
 * @since 1.0.0
 * 
 */
class m160312_050000_create_user extends Migration
{
    private $userTable = 'user';

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Check if the table exists
        if ($this->db->schema->getTableSchema($this->userTable, true) === null) {
            $this->createTable($this->userTable, [
                'id' => $this->primaryKey(),
                'username' => $this->string(32)->notNull(),
                'auth_key' => $this->string(32)->notNull(),
                'password_hash' => $this->string()->notNull(),
                'password_reset_token' => $this->string(),
                'email' => $this->string()->notNull(),
                'status' => $this->smallInteger()->notNull()->defaultValue(10),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
                ], $tableOptions);
        }
    }

    public function down()
    {
        if ($this->db->schema->getTableSchema($this->userTable, true) !== null) {
            $this->dropTable($this->userTable);
        }
    }
}
