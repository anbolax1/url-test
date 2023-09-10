<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "url".
 *
 * @property int $id
 * @property string $hash_string
 * @property string $url
 * @property int $status_code
 * @property int $query_count
 * @property int $error_count
 * @property int $created_at
 * @property int $updated_at
 */
class Url extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'url';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hash_string', 'url', 'status_code', 'query_count', 'error_count', 'created_at', 'updated_at'], 'required'],
            [['status_code', 'query_count', 'error_count', 'created_at', 'updated_at'], 'integer'],
            [['hash_string', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hash_string' => 'Hash String',
            'url' => 'Url',
            'status_code' => 'Status Code',
            'query_count' => 'Query Count',
            'error_count' => 'Error Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
