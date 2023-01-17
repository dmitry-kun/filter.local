<?php


class PropertyWorker
{
    private $propertyName;
    private $acfType;
    private $outputType;
    private $isOff;
    private $arrayPropertyKeys = ['acf_type', 'type', 'show'];

    public function __construct($propertyName) {
        $this->propertyName = $propertyName;
    }

    public function __get($name)
    {
        if (property_exists(__CLASS__ , $name)) {
            return $this->$name;
        }

        $trace = debug_backtrace();
        trigger_error(
            'Неопределённое свойство в __get(): ' . $name .
            ' в файле ' . $trace[0]['file'] .
            ' на строке ' . $trace[0]['line'],
            E_USER_NOTICE);
        return null;
    }

    private function getProperty()
    {
        return get_option('cf_'.$this->propertyName);
    }

    private function getPropertyValueAsArray()
    {
        $baseValue = $this->getProperty();
        if ($baseValue) {
            return json_decode($baseValue);
        }
        return false;
    }

    public function setFields()
    {
        $fieldsArr = $this->getPropertyValueAsArray();
        if(is_array($fieldsArr)) {
            $this->installFields($fieldsArr);
        }
    }

    /**
     * @param $fieldsArr array - field's array using acf_type, type and show keys
     * @return string
     */
    public function updateProperty($fieldsArr)
    {
        try{
            if(!(is_array($fieldsArr) && !empty($fieldsArr))) {
                throw new Exception('Полученное значение не является массивом.');
            }
            $checkKeysRes = $this->checkPropertyKeysInArray($fieldsArr);
            if(is_array($checkKeysRes)) {
                throw new Exception(implode('/', $checkKeysRes));
            }
            $this->installFields($fieldsArr);

            update_option( 'cf_'.$this->propertyName, json_encode($fieldsArr) );

        } catch (Exception $e) {
            return $e->getMessage();
        }
        return 'ok';
    }

    private function installFields($fieldsArr)
    {
        foreach ($fieldsArr as $fieldName => $fieldVal) {
            switch ($fieldName) {
                case 'acf_type':
                    $this->acfType = $fieldVal;
                    break;
                case 'type':
                    $this->outputType = $fieldVal;
                    break;
                case 'show':
                    $this->isOff = $fieldVal;
                    break;
                default:
                    break;
            }
        }
    }

    private function checkPropertyKeysInArray($fieldsArr)
    {
        $messagesArray = [];
        foreach ($this->arrayPropertyKeys as $k=>$propertyKey) {
            if (!array_key_exists($propertyKey, $fieldsArr)) {
                $messagesArray[$k] = 'Массив не содержит ключа '.$propertyKey;
            }
        }
        if(!empty($messagesArray)) {
            return $messagesArray;
        }
        return true;
    }
}