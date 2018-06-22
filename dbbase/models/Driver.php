<?php

namespace dbbase\models;

use Yii;

/**
 * This is the model class for table "{{%driver}}".
 *
 * @property int $id ID
 * @property string $qd_name 包名称
 * @property string $qd_file_size 大小
 * @property string $qd_sha256 哈希值
 * @property int $qd_install_type 安装方式,0:未知,1:inf,2:exe
 * @property string $qd_source 来源
 * @property string $qd_download_url 下载地址
 * @property string $qd_instruction 说明
 * @property int $rank 权重
 * @property string $language 语言
 * @property string $parameter 参数
 * @property string $note 备注
 * @property string $type 类型
 * @property string $created_at 创建时间
 * @property string $updated_at 编辑时间
 * @property int $is_del 是否删除
 */
class Driver extends \dbbase\models\BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%driver}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['qd_install_type', 'rank', 'is_del'], 'integer'],
            [['qd_instruction'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['qd_name', 'qd_file_size', 'language', 'type'], 'string', 'max' => 255],
            [['qd_sha256', 'qd_source', 'qd_download_url', 'parameter', 'note'], 'string', 'max' => 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'qd_name' => Yii::t('app', '包名称'),
            'qd_file_size' => Yii::t('app', '大小'),
            'qd_sha256' => Yii::t('app', '哈希值'),
            'qd_install_type' => Yii::t('app', '安装方式,0:未知,1:inf,2:exe'),
            'qd_source' => Yii::t('app', '来源'),
            'qd_download_url' => Yii::t('app', '下载地址'),
            'qd_instruction' => Yii::t('app', '说明'),
            'rank' => Yii::t('app', '权重'),
            'language' => Yii::t('app', '语言'),
            'parameter' => Yii::t('app', '参数'),
            'note' => Yii::t('app', '备注'),
            'type' => Yii::t('app', '类型'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '编辑时间'),
            'is_del' => Yii::t('app', '是否删除'),
        ];
    }
}
