<?php

namespace app\modules\shorts\models;

use Yii;

/**
 * This is the model class for table "ip".
 *
 * @property int $id
 * @property string $ip
 *
 * @property Link[] $links
 * @property Log[] $logs
 */
class Ip extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ip';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip'], 'required'],
            [['ip'], 'string', 'max' => 255],
            [['ip'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
        ];
    }

    /**
     * Gets query for [[Links]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLinks()
    {
        return $this->hasMany(Link::class, ['id' => 'link_id'])->viaTable('log', ['ip_id' => 'id']);
    }

    /**
     * Gets query for [[Logs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(Log::class, ['ip_id' => 'id']);
    }

}
