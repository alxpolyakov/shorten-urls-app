<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hits".
 *
 * @property int $id
 * @property string $client_ip
 * @property string $ts
 * @property int $url_id
 *
 * @property Urls $url
 */
class Hit extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['remote_ip', 'link_id'], 'required'],
            [['ts'], 'safe'],
            [['link_id'], 'integer'],
            [['remote_ip'], 'string', 'max' => 16],
            [['link_id'], 'exist', 'skipOnError' => true, 'targetClass' => Link::class, 'targetAttribute' => ['link_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_ip' => 'Client Ip',
            'ts' => 'Ts',
            'link_id' => 'Link ID',
        ];
    }

    /**
     * Gets query for [[Url]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUrl()
    {
        return $this->hasOne(Link::class, ['id' => 'link_id']);
    }

}
