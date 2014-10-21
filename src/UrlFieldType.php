<?php namespace Anomaly\Streams\Addon\FieldType\Url;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAddon;

class UrlFieldType extends FieldTypeAddon
{
    /**
     * Initial field type validation requirements.
     *
     * @var array
     */
    public $validation = array(
        'url'
    );

    /**
     * Return the input used for forms.
     *
     * @return mixed
     */
    public function input()
    {
        return \Form::input('text', $this->inputName(), $this->value());
    }
}
