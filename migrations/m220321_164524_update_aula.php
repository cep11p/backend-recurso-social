<?php

use yii\db\Migration;

/**
 * Class m220321_164524_update_aula
 */
class m220321_164524_update_aula extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $table = "aula";

        $this->addColumn($table,'baja', $this->boolean()->defaultValue(0));
        $this->addColumn($table,'motivo_baja', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220321_164524_update_aula cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220321_164524_update_aula cannot be reverted.\n";

        return false;
    }
    */
}
