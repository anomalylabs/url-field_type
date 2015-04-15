<?php namespace Anomaly\UrlFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;

/**
 * Class UrlFieldTypePresenter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\UrlFieldType
 */
class UrlFieldTypePresenter extends FieldTypePresenter
{

    /**
     * The decorated object.
     * This is for IDE support.
     *
     * @var UrlFieldType
     */
    protected $object;

    /**
     * Return a link.
     *
     * @param null $text
     * @return bool
     */
    public function link($title = null, $attributes = [])
    {
        if (!$title) {
            $title = $this->object->getValue();
        }

        if (!$url = $this->object->getValue()) {
            return null;
        }

        return app('html')->link($url, $title, $attributes);
    }
}
