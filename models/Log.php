<?php

namespace app\modules\shorts\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property int $link_id
 * @property int $ip_id
 * @property int|null $count
 *
 * @property Ip $ip
 * @property Link $link
 */
class Log extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['count'], 'default', 'value' => 1],
            [['link_id', 'ip_id'], 'required'],
            [['link_id', 'ip_id', 'count'], 'integer'],
            [['link_id', 'ip_id'], 'unique', 'targetAttribute' => ['link_id', 'ip_id']],
            [['ip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ip::class, 'targetAttribute' => ['ip_id' => 'id']],
            [['link_id'], 'exist', 'skipOnError' => true, 'targetClass' => Link::class, 'targetAttribute' => ['link_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'link_id' => 'Link ID',
            'ip_id' => 'Ip ID',
            'count' => 'Count',
        ];
    }

    /**
     * Gets query for [[Ip]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIp()
    {
        return $this->hasOne(Ip::class, ['id' => 'ip_id']);
    }

    /**
     * Gets query for [[Link]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLink()
    {
        return $this->hasOne(Link::class, ['id' => 'link_id']);
    }

}
