<?php namespace Anomaly\Streams\Addon\FieldType\Url;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;

/**
 * Class UrlFieldTypePresenter
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Addon\FieldType\Url
 */
class UrlFieldTypePresenter extends FieldTypePresenter
{

    /**
     * Return the link for a URL.
     *
     * @param null  $title
     * @param array $attributes
     * @return null
     */
    public function link($title = null, $attributes = [])
    {
        if ($url = $this->resource->getValue()) {

            return app('html')->link($url, $title, $attributes);
        }

        return null;
    }
}
 