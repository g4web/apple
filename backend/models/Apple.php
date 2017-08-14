<?php

namespace backend\models;

use \yii\db\ActiveRecord;

/**
 * This is the model class for table "apple".
 *
 * @property integer $id
 * @property string $color
 * @property integer $coordinate_x
 * @property integer $coordinate_y
 * @property string $appearance_date
 * @property string $fall_date
 * @property integer $status
 * @property integer $percent
 */
class Apple extends ActiveRecord
{

    const DEFAULT_PERCENT = 100;

    const STATUS_ON_TREE = 1;
    const STATUS_ON_GROUND = 2;
    const STATUS_ROTTED = 3;
    const STATUS_DELETED = 4;

    const COORDINATE_MAX_WIDTH = 400;
    const COORDINATE_MAX_HEIGHT = 300;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'apple';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['color', 'status'], 'required'],
            [['coordinate_x', 'coordinate_y', 'status', 'percent'], 'integer'],
            [['appearance_date', 'fall_date'], 'safe'],
            [['color'], 'string', 'max' => 6],
            [['id'], 'integer', 'max' => 99999999999],
            [['percent'], 'integer', 'min' => '0', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Color',
            'coordinate_x' => 'Coordinate X',
            'coordinate_y' => 'Coordinate Y',
            'appearance_date' => 'Appearance Date',
            'fall_date' => 'Fall Date',
            'status' => 'Status',
            'percent' => 'Percent',
        ];
    }


    public function __construct(array $config = [])
    {

        $this->color = $this->_randomRGB();
        $this->coordinate_x = rand(1, self::COORDINATE_MAX_WIDTH);
        $this->coordinate_y = rand(1, self::COORDINATE_MAX_HEIGHT);
        $this->status = self::STATUS_ON_TREE;
        $this->percent = self::DEFAULT_PERCENT;
        $this->appearance_date = date('Y-m-d H:i:s', rand(0, time()));

        parent::__construct($config);
    }

    public function getSize()
    {
        return $this->percent / 100;
    }

    protected function _randomRGB()
    {
        return sprintf('%02X%02X%02X', rand(122, 255), rand(122, 255), rand(0, 0));
    }
}
