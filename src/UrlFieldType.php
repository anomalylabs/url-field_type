<?php namespace Anomaly\Streams\Addon\FieldType\Url;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAddon;

class UrlFieldType extends FieldTypeAddon
{
    public $columnType = 'string';

    public $validation = array(
        'url'
    );

    public function input()
    {
        return \Form::input('text', $this->inputName(), $this->value);
    }
}
