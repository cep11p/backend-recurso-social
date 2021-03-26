<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "cuota".
 *
 * @property integer $id
 * @property double $monto
 * @property integer $recursoid
 * @property string $fecha_pago
 *
 * @property \app\models\Recurso $recurso
 * @property string $aliasModel
 */
abstract class Cuenta extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cuota';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['monto'], 'number'],
            [['recursoid'], 'required'],
            [['recursoid'], 'integer'],
            [['fecha_pago'], 'safe'],
            [['recursoid'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Recurso::className(), 'targetAttribute' => ['recursoid' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'monto' => 'Monto',
            'recursoid' => 'Recursoid',
            'fecha_pago' => 'Fecha Pago',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecurso()
    {
        return $this->hasOne(\app\models\Recurso::className(), ['id' => 'recursoid']);
    }




}
