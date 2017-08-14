<?php

use yii\db\Migration;

class m170814_035304_create_apple extends Migration
{
    public function safeUp()
    {
        $this->createTable('apple', [
            'id' => $this->primaryKey(),
            'color' => $this->string(6)->notNull(),
            'coordinate_x' => $this->integer(3)->defaultValue(null),
            'coordinate_y' => $this->integer(3)->defaultValue(null),
            'appearance_date'=> $this->dateTime()->notNull(),
            'fall_date'=> $this->dateTime()->defaultValue(null),
            'status' => $this->integer(1)->notNull(),
            'percent' => $this->integer(3)->defaultValue(100)->notNull()
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('apple');

        return true;
    }
}
