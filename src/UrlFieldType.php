<?php namespace Streams\Addon\FieldType\Url;

use Streams\Core\Addon\FieldTypeAbstract;

class UrlFieldType extends FieldTypeAbstract
{
    /**
     * The database column type this field type uses.
     *
     * @var string
     */
    public $columnType = 'string';

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
