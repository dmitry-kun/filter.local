<?php

//todo добавить сопоставления допустимых типов полей с типом фильтра (селект, чекбокс, диапазон(только для числовых) )
class FieldWatcher
{
    public static $allowedFieldTypes = ['number', 'text', 'range', 'select', 'checkbox', 'radio', 'true_false'];

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
}