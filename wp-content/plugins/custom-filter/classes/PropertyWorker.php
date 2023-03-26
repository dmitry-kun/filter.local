<?php


class PropertyWorker
{
    private $propertyName; //название свойства в таблице
    private $propertyArray = [];
    private $arrayPropertyKeys = ['acf_name', 'type', 'show', 'sort'];

    // deprecated fields below
    private $acfName; // Ключ поля acf
    private $outputType; // выводимый тип (то, как будет выглядеть в самом фильтре)
    private $isShow; // выводить - да/net
    private $sort; // сортировка


    public function __construct($propertyName) {
        $this->propertyName = $propertyName;
        $this->setFields();
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
            $this->propertyArray = $fieldsArr;
        }
    }

    public function getPropertyArray()
    {
        return $this->propertyArray;
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

            $isUpdateFieldsArray = $this->setNewPropertyInPropertyList($fieldsArr);
            if (!$isUpdateFieldsArray) {
                throw new Exception('Ошибка в методе setNewPropertyInPropertyList');
            }

            update_option( 'cf_'.$this->propertyName, json_encode($this->propertyArray) );

        } catch (Exception $e) {
            return $e->getMessage();
        }
        return 'ok';
    }

    //deprecated method
    private function installFields($fieldsArr)
    {
        foreach ($fieldsArr as $fieldName => $fieldVal) {
            switch ($fieldName) {
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

    private function setNewPropertyInPropertyList($fieldsArr)
    {
        if( !$fieldsArr['acf_name'] ||
            !$fieldsArr['type'] ||
            !$fieldsArr['show'] ||
            $fieldsArr['sort']
        ) {
            return false;
        }
        $this->propertyArray[$fieldsArr['acf_name']]['type'] = $fieldsArr['type'];
        $this->propertyArray[$fieldsArr['acf_name']]['show'] = $fieldsArr['show'];
        $this->propertyArray[$fieldsArr['acf_name']]['sort'] = $fieldsArr['sort'];
        return true;
    }
}