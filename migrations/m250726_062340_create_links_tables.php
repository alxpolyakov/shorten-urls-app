<?php

use yii\db\Migration;
use yii\db\Schema;


class m250726_062340_create_links_tables extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('links', [
            'id' => $this->primaryKey(11),
            'long_url' => $this->string(511)->notNull(),
            'short_url' => $this->string(511)->notNull(),
            'response_code' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->dateTime()->notNull(),
            'hits_count' => $this->integer()->notNull()->defaultValue(0),
        ]);
        $this->createTable('hits', [
            'id' => $this->primaryKey(11),
            'link_id' => $this->integer(),
            'ts' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'remote_ip' => $this->string(16)->notNull()
        ]);
        $this->addForeignKey('fk_link_id',
            'hits',
            'link_id',
            'links',
            'id',
            'CASCADE');
        $this->createIndex('remote_ip', 'hits', 'remote_ip', false);
        $this->createIndex('ts', 'hits', 'ts', false);
        $this->createIndex('long_url', 'links', 'long_url', true);
        $this->createIndex('short_url', 'links', 'short_url', true);

    }

    public function down()
    {
        echo "m250726_062340_create_links_tables cannot be reverted.\n";
        $this->dropForeignKey('fk_link_id', 'hits');

        // drops index for column `author_id`
        $this->dropIndex('remote_ip','hits');
        $this->dropIndex('ts','hits');
        $this->dropIndex('long_url','links');
        $this->dropIndex('short_url','links');

        $this->dropTable('links');
        $this->dropTable('hits');

        return false;
    }

}
