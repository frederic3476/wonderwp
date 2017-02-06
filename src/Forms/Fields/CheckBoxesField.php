<?php
/**
 * Created by PhpStorm.
 * User: jeremydesvaux
 * Date: 31/08/2016
 * Time: 12:26
 */

namespace WonderWp\Forms\Fields;

use WonderWp\Forms\Fields\FieldGroup;

class CheckBoxesField extends FieldGroup
{

    public function __construct($name, $value = null, $displayRules = array(), $validationRules = array())
    {
        parent::__construct($name, $value, $displayRules, $validationRules);
        if(empty($this->displayRules['wrapAttributes']['class'])){ $this->displayRules['wrapAttributes']['class']=array(); }
        $this->displayRules['wrapAttributes']['class'][] = 'checkbox-group';
    }

    public function generateCheckBoxes($passedGroupedDisplayRules=array(),$passedGroupedValidationRules=array())
    {
        $name = $this->getName();
        if (!empty($this->options)) {
            foreach ($this->options as $val => $label) {
                $optFieldName = $name . '.' . $val . '';
                $defaultOptDisplayRules = array(
                    'label' => $label,
                    'inputAttributes' => array(
                        'name' => $name . '[' . $val . ']',
                        'value' => $val
                    )
                );
                $passedOptDisplayRules = isset($passedGroupedDisplayRules[$val]) ? $passedGroupedDisplayRules[$val] : array();
                $optDisplayRules =\WonderWp\array_merge_recursive_distinct($defaultOptDisplayRules,$passedOptDisplayRules);

                $optField = new CheckBoxField($optFieldName, isset($this->value[$val]) ? $this->value[$val] : null, $optDisplayRules);
                $this->addFieldToGroup($optField);
            }
        }
        return $this;
    }

    public function setValue($value)
    {
        parent::setValue($value);

        if(!empty($this->group)){
            foreach ($this->group as $cbField){
                /** @var CheckBoxField $cbField */
                $displayRules = $cbField->getDisplayRules();
                $value = !empty($displayRules['inputAttributes']['value']) ? $displayRules['inputAttributes']['value'] : null;
                if(!empty($value) && isset($this->value[$value])){
                    $cbField->setValue($this->value[$value]);
                }
            }
        }
        return $this;
    }

}
