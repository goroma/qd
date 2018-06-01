<?php 
 
namespace api\modules\v2\models;
 
use \yii\db\ActiveRecord;
/**
 * Country Model
 */
class Country extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%country}}';
    }
 
    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
    }
 
    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['code', 'name', 'population'], 'required']
        ];
    }

    /**
     * test create.
     */
    public static function createCountry()
    {
        $model = new Country;
        $model->code = rand(-99, 99);
        $model->name = 'CHAIN';
        $model->population = 1234;

        return $model->save();
    }
}
