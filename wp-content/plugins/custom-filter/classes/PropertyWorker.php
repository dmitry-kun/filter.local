<?php


class PropertyWorker
{
    private $propertyName; //название свойства в таблице
    private $acfType; //тип поля acf (number, select etc.)
    private $acfName; // Ключ поля acf
    private $outputType; // выводимый тип (то, как будет выглядеть в самом фильтре)
    private $isShow; // выводить - да/net
    private $sort; // сортировка
    private $arrayPropertyKeys = ['acf_type', 'acf_name', 'type', 'show', 'sort'];

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
        if (!Helper::option_exists('cf_'.$this->propertyName)) {
            add_option('cf_'.$this->propertyName, "");
        }
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
     * @param $fieldsArr array - field's array using acf_type, type, show and sort keys
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
                case 'acf_name':
                    $this->acfName = $fieldVal;
                    break;
                case 'type':
                    $this->outputType = $fieldVal;
                    break;
                case 'show':
                    $this->isShow = $fieldVal;
                    break;
                case 'sort':
                    $this->sort = $fieldVal;
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