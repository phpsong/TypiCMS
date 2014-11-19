<?php
namespace TypiCMS\Services\Form;

use AdamWathan\Form\FormBuilder as OriginalFormBuilder;
use Config;

class FormBuilder extends OriginalFormBuilder
{

    public function bind($model)
    {
        $this->model = is_array($model) ? (object) $model : $model;
    }

    protected function getValueFor($name)
    {
        return parent::getValueFor($name);
    }

    protected function hasModelValue($name)
    {
        if (! isset($this->model)) {
            return false;
        }
        return isset($this->model->{$name}) || method_exists($this->model, '__get');
    }

    /**
     * Getting value from Model or ModelTranslation to populate form
     * 
     * @param  string $name key
     * @return string       value
     */
    protected function getModelValue($name)
    {
        $array = preg_split('/[\[\]]+/', $name, -1, PREG_SPLIT_NO_EMPTY);
        if (count($array) == 2 and in_array($array[0], Config::get('app.locales'))) {
            list($lang, $name) = $array;
            $value = $this->model->translate($lang)->{$name};
            return $this->escapeQuotes($value);
        }
        return $this->escapeQuotes($this->model->{$name});
    }
}