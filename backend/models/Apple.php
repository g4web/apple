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
            [['id'], 'integer',  'max' => 99999999999],
            [['percent'], 'integer',  'max' => 100],
            ['percent', 'validatePercent'],
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


    public function validatePercent($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if($this->percent > 100){
                $this->addError($attribute, 'Incorrect percent');
            }
        }
    }
    /**
     *  ========================== PUBLIC METHODS ==========================
     */
    public function __construct(array $config = [])
    {

        $this->color = $this->_randomColor();
        $this->coordinate_x = rand(0, self::COORDINATE_MAX_WIDTH);
        $this->coordinate_y = rand(0, self::COORDINATE_MAX_HEIGHT);
        $this->status = self::STATUS_ON_TREE;
        $this->percent = self::DEFAULT_PERCENT;
        $this->appearance_date = date('Y-m-d H:i:s');

        parent::__construct($config);
    }


    public function fallToGround()
    {
        if ($this->status === self::STATUS_ON_TREE) {
            $this->status = self::STATUS_ON_GROUND;
            $this->coordinate_y = 0;
            $this->fall_date = date('Y-m-d H:i:s');
        } else {
            //$this->addError('status', 'Яблоко не на дереве');
            throw new \Exception('Яблоко не на дереве');
        }
    }

    public function eat($eatablePercent, AppleEaterInterface $eater)
    {
        $eater->checkEating($this);
        $this->_checkStatusEating();
        $this->_checkPercentEating($eatablePercent);
        $this->percent -= $eatablePercent;
        if (empty($this->percent)) {
            $this->delete();
        }
    }

    public function delete()
    {
        if ($this->percent > 0) {
            //$this->addError('percent', 'Яблоко еще не доеденно');
            throw new \Exception("Яблоко еще не доеденно");
        }
        $this->status = self::STATUS_DELETED;
    }

    public function getSize()
    {
        return $this->percent / 100;
    }

    /**
     *  ========================== PROTECTED/PRIVATE METHODS ==========================
     */
    protected function _checkPercentEating($eatablePercent)
    {
        if ($this->percent < $eatablePercent) {
            //$this->addError('percent', "Нельзя съесть $eatablePercent % яблока, осталось только $this->percent %");
            throw new \Exception("Нельзя съесть $eatablePercent % яблока, осталось только $this->percent %");
        }
    }

    protected function _checkStatusEating()
    {
        if ($this->percent <= 0 || $this->status === self::STATUS_DELETED) {
            //$this->addError('percent', "От яблока ничего не осталось");
            throw new \Exception("От яблока ничего не осталось");
        }
    }

    protected function _randomColor()
    {
        return sprintf('%02X%02X%02X', rand(122, 255), rand(122, 255), rand(0, 0));
    }
}
