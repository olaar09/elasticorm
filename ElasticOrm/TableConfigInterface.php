<?php

/**
 * Description of TableConfigInterface
 *
 * @author olaar
 */
interface TableConfigInterface {

    //put your code here

    public function setTable($tableName);

    public function setPk($pkColumn);

//    public function setRules(array $rules);
//    
//    public function beforeSave($controls, $callBack);
//
//    public function afterSave($controls, $callBack);
//
//    public function beforeDelete($controls, $callBack);
//
//    public function afterDelete($controls, $callBack);
//
//    public function beforeUpdate($controls, $callBack);
//
//    public function afterSaveUpdate($cntrols, $callBack);
}
