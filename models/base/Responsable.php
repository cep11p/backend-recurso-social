<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "responsable".
 *
 * @property integer $id
 * @property integer $tipo_responsableid
 * @property integer $responsableid
 *
 * @property \app\models\Recurso[] $recursos
 * @property string $aliasModel
 */
abstract class Responsable extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'responsable';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipo_responsableid', 'responsableid'], 'required'],
            [['tipo_responsableid', 'responsableid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo_responsableid' => 'Tipo Responsableid',
            'responsableid' => 'Responsableid',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'tipo_responsableid' => 'esto nos permite tener multiples tipos de responsables. ej municipio, delegacion, comision de fomente,etc',
            'responsableid' => 'estos responsables son obtenidos desde el sistema lugar mediante interoperablidad, donde el tipo de responsable nos identifica que tabla viene el responsable',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecursos()
    {
        return $this->hasMany(\app\models\Recurso::className(), ['responsable_entregaid' => 'id']);
    }




}