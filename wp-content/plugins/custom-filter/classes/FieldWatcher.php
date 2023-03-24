<?php

//todo добавить сопоставления допустимых типов полей с типом фильтра (селект, чекбокс, диапазон(только для числовых) )
class FieldWatcher
{
    private static $allowedFieldTypes = ['number', 'text', 'range', 'select', 'checkbox', 'radio', 'true_false'];
    const CHECKBOX_TYPE = ['checkbox' => 'Чекбокс'];
    const RADIO_TYPE = ['radio' => 'Радио-кнопка'];
    const SELECT_TYPE = ['select' => 'Селект'];
    const RANGE_TYPE = ['range' => 'Диапазон'];

    /**
     * @param $fieldType string
     * @return bool
     */
    public static function checkIsFieldTypeAllowed($fieldType)
    {
        if(in_array($fieldType, self::$allowedFieldTypes)) {
            return true;
        }

        return false;
    }

    public static function getAllowedFilterTypesByFieldType($fieldType)
    {
        $filterTypes = [];
        switch ($fieldType){
            case 'number':
                $filterTypes = self::CHECKBOX_TYPE + self::RADIO_TYPE + self::SELECT_TYPE + self::RANGE_TYPE;
                break;
            case 'text':
            case 'select':
            case 'checkbox':
            case 'radio':
            case 'true_false':
                $filterTypes = self::CHECKBOX_TYPE + self::RADIO_TYPE + self::SELECT_TYPE;
                break;
            case 'range':
                $filterTypes = self::RANGE_TYPE;
            default:
                break;
        }
        return $filterTypes;
    }

    /**
     * @param string $fieldName - название поля для name селекта (ключ поля в acf)
     * @param string $fieldType - тип поля в acf (number', 'text' и т.д.)
     * @param string $selectedType - выбранный тип фильтра у сохраненного поля
     */
    public static function printFilterTypesSelect($fieldName, $fieldType, $selectedType = '')
    {
        $filterTypes = self::getAllowedFilterTypesByFieldType($fieldType)
        //todo переделать в кастомный селект
        ?>
        <select name="<?=$fieldName?>">
            <option <?=$selectedType ? '' : 'selected'?> disabled>Выбрать</option>
            <? foreach ($filterTypes as $k => $option) { ?>
                <option <?=$selectedType == $k ? 'selected' : ''?> value="<?=$k?>"><?=$option?></option>
            <? } ?>
        </select>
        <?
    }
}