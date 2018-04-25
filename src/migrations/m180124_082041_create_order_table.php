<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m180124_082041_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'sn' => $this->string()->notNull()->comment('订单号'),
            'game_id' => $this->smallInteger()->notNull()->unsigned()->comment('游戏ID'),
            'type' => $this->smallInteger()->notNull()->unsigned()->comment('订单分类'),
            'user_id' => $this->integer()->notNull()->unsigned()->comment('用户ID'),
            'count' => $this->integer()->notNull()->comment('数量'),
            'hours' => $this->integer()->notNull()->comment('时间'),
            'final_price' => $this->float()->notNull()->comment('final_price'),
            'equipment' => $this->smallInteger()->notNull()->comment('区服信息'),
            'serverinfo' => $this->string()->comment('详细区服信息'),
            'account' => $this->string()->notNull()->comment('用户帐号/游戏昵称'), //王者荣耀为QQ/微信帐号,吃鸡游戏为游戏昵称
            //'password' => $this->string()->comment('王者荣耀代打订单必须 需要用户帐号和密码'),
            'remark' => $this->string(100)->comment('备注'),
            'status' => $this->smallInteger()->notNull()->comment('订单状态'),
            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->comment('更新时间'),
            'payment_method' => $this->smallInteger()->notNull()->comment('支付方式'),
            //'client_id' => $this->string()->notNull()->defaultValue('')->comment('客户端'),
            'name' => $this->string()->notNull()->defaultValue('')->comment('订单名称'),
            //'description' => $this->string()->comment('描述'),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%order}}');
    }
}
