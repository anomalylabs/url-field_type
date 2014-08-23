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
     * Field type version
     *
     * @var string
     */
    public $version = '1.1.0';

    /**
     * Initial field type validation requirements.
     *
     * @var array
     */
    public $validation = array(
        'url'
    );

    /**
     * Field type author information.
     *
     * @var array
     */
    public $author = array(
        'name' => 'AI Web Systems, Inc.',
        'url'  => 'http://aiwebsystems.com/',
    );

    /**
     * Return the input used for forms.
     *
     * @return mixed
     */
    public function formInput()
    {
        return \Form::input('email', $this->formSlug, $this->value);
    }
}
