<?php

namespace common\models;

use Yii;

class InputTypes extends CcObjectProperties
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function InputType($object_ownership='provider')
    {
        switch ($this->inputType($object_ownership)) {
            case '_number':
                return $this->renderPartial('/form/_number', []) 
                break;
            case '_range':
                $input = ($object_ownership=='user') ? '_radio' : '_multiselect';
                break;
            case '_radio':
                $input = ($object_ownership=='user') ? '_radioButton' : '_checkboxButton';
                break;
            case '_radioButton':
                $input = '_radio';
            case '_multiselect':
                $input = '_radioButton';
                break;
            case '_checkboxButton':
                $input = ($object_ownership=='user') ? '_select' : '_multiselect';
                break;
            case '_select':
                $input = ($object_ownership=='user') ? '_select2' : '_multiselect_select2';
                break;
            case '_select2':
                $input = ($object_ownership=='user') ? '_select_media' : '_multiselect_media';
                break;
            case '_multiselect_select2':
                $input = '_multiselect';
                break;            
            case '_select_media':
                $input = '_checkboxButton';
                break;
            case '_multiselect_media':
                $input = '_multiselect_select';
                break;
            case '_multiselect_media_count':
                $input = '_multiselect_select2';
                break;
            case '_checkbox':
                $input = '_multiselect_media';
                break;
            case '_text':
                $input = '_multiselect_media_count';
                break;
            case '_textarea':
                $input = '_checkbox';
                break;
            case '_slider':
                $input = ($object_ownership=='user') ? '_text' : null;
                break;
            case '_date':
                $input = ($object_ownership=='user') ? '_textarea' : null;
                break;
            case '_time':
                $input = '_slider';
                break;
            case '_datetime':
                $input = '_range'; // with operator
                break;
            case '_email':
                $input = '_date';
                break;
            case '_url':
                $input = '_time';
                break;
            case '_date_range':
                $input = '_datetime';
                break;
            case '_file':
                $input = '_email';
                break;
            default:
                $input = '_text';
                break;
        }       
        return $input;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function formTypePresentation($object_ownership='provider')
    {
        switch ($this->type) {
            case 1:
                $part = '_number';
                break;
            case 2:
                $part = ($object_ownership=='provider') ? '_radio' : '_multiselect';
                break;
            case 21:
                $part = ($object_ownership=='provider') ? '_radioButton' : '_checkboxButton';
                break;
            case 22:
                $part = '_radio';
            case 23:
                $part = '_radioButton';
                break;
            case 3:
                $part = ($object_ownership=='provider') ? '_select' : '_multiselect';
                break;
            case 31:
                $part = ($object_ownership=='provider') ? '_select2' : '_multiselect';
                break;
            case 32:
                $part = ($object_ownership=='provider') ? '_select_media' : '_multiselect';
                break;
            case 4:
                $part = '_multiselect';
                break;            
            case 41:
                $part = '_checkboxButton';
                break;
            case 42:
                $part = '_multiselect_select';
                break;
            case 43:
                $part = '_multiselect_select2';
                break;
            case 44:
                $part = '_multiselect_media';
                break;
            case 45:
                $part = '_multiselect_media_count';
                break;
            case 5:
                $part = '_checkbox';
                break;            
            case 6:
                $part = ($object_ownership=='provider') ? '_text' : null;
                break;
            case 7:
                $part = ($object_ownership=='provider') ? '_textarea' : null;
                break;
            case 8:
                $part = '_slider';
                break;
            case 9:
                $part = '_range';
                break;
            case 10:
                $part = '_date';
                break;
            case 11:
                $part = '_time';
                break;
            case 12:
                $part = '_datetime';
                break;
            case 13:
                $part = '_email';
                break;
            case 14:
                $part = '_url';
                break;
            case 15:
                $part = '_color';
                break;
            case 16:
                $part = '_date_range';
                break;
            case 99:
                $part = '_file';
                break;
            default:
                $part = '_text';
                break;
        }       
        return $part;
    } 
}
