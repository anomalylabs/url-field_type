<?php namespace Anomaly\Streams\Addon\FieldType\Url;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypeAddon;

/**
 * Class UrlFieldType
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Addon\FieldType\Url
 */
class UrlFieldType extends FieldTypeAddon
{

    /**
     * Base field type rules.
     *
     * @var array
     */
    protected $rules = array(
        'url'
    );

    /**
     * Return the input HTML.
     *
     * @return mixed
     */
    public function input()
    {
        $placeholder = $this->getPlaceholder();

        return app('form')->url($this->getFieldName(), $this->getValue(), compact('placeholder'));
    }
}
