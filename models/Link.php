<?php

namespace app\modules\shorts\models;

use Yii;

/**
 * This is the model class for table "link".
 *
 * @property int $id
 * @property string $url
 *
 * @property Ip[] $ips
 * @property Log[] $logs
 */
class Link extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'link';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['url'], 'string', 'max' => 255],
            [['url'], 'unique'],
            [['url'], 'url'],
            [['url'], 'accessableUrl'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
        ];
    }

    /**
     * Gets query for [[Ips]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIps()
    {
        return $this->hasMany(Ip::class, ['id' => 'ip_id'])->viaTable('log', ['link_id' => 'id']);
    }

    /**
     * Gets query for [[Logs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(Log::class, ['link_id' => 'id']);
    }

    public function accessableUrl($attribute, $params)
    {
        
        $client = new \GuzzleHttp\Client();
        
        try{
            $httpResponse = $client->get($this->$attribute);
            $statusCode = $httpResponse->getStatusCode();
            //echo $statusCode;
        }catch(\Exception $e){
            $statusCode = 500;            
        }
        
        if ($statusCode >= 400) {
            
            $this->addError($attribute, 'Данный url недоступен');
        }else{
            
        }
    }

    

}
