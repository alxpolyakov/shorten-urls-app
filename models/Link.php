<?php

namespace app\models;
use chillerlan\QRCode\QRCode;
use Yii;

/**
 * This is the model class for table "urls".
 *
 * @property int $id
 * @property string $long_url
 * @property string $short_url
 * @property string $created_at
 * @property int $hits_count
 * @property int $response_code
 *
 * @property Hits[] $hits
 */
class Link extends \yii\db\ActiveRecord
{
//    public string $long_url;
//    public string $short_url;
//    public string $created_at;
//    public int $hits_count;
//    public int $response_code;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['response_code'], 'default', 'value' => null],
            [['hits_count'], 'default', 'value' => 0],
            [['long_url', 'short_url'], 'required'],
            [['response_code', 'hits_count'], 'integer'],
            [['created_at'], 'safe'],
            [['long_url', 'short_url'], 'string', 'max' => 511],
            [['long_url'], 'unique'],
            [['short_url'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'long_url' => 'Long Url',
            'short_url' => 'Short Url',
            'created_at' => 'Created At',
            'hits_count' => 'Hits Count',
        ];
    }

    public function getQRCode(){
        return (new QRCode)->render($this->long_url);
    }

    public static function generateShortCode($length=6) {
        $letters = 'abcdefghijklmnopqrstuvwxyz';
        $characters = '0123456789'.$letters.strtoupper($letters);
        $res = '';
        for ($i = 0; $i < $length; $i++) {
            $res .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $res;
    }

    /**
     * Gets query for [[Hits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHits()
    {
        return $this->hasMany(Hits::class, ['url_id' => 'id']);
    }

}