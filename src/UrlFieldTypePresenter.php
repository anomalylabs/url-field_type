<?php namespace Anomaly\UrlFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldTypePresenter;
use Collective\Html\HtmlBuilder;

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
     * The HTML builder.
     *
     * @var HtmlBuilder
     */
    protected $html;

    /**
     * Create a new UrlFieldTypePresenter instance.
     *
     * @param HtmlBuilder $html
     * @param             $object
     */
    public function __construct(HtmlBuilder $html, $object)
    {
        $this->html = $html;

        parent::__construct($object);
    }


    /**
     * Return the parsed query string.
     *
     * @param null $key
     * @return null|mixed
     */
    public function query($key = null)
    {
        if (!$parsed = $this->parsed()) {
            return null;
        }

        parse_str(array_get($parsed, 'query'), $query);

        if ($key) {
            return array_get($query, $key);
        }

        return $query;
    }

    /**
     * Return the parsed URL.
     *
     * @return array|null
     */
    public function parsed()
    {
        if ($url = $this->object->getValue()) {
            return parse_url($url);
        }

        return null;
    }

    /**
     * Return a link.
     *
     * @param null $text
     * @return bool
     */
    public function link($title = null, $attributes = [])
    {
        if (!$url = $this->object->getValue()) {
            return null;
        }

        if (!$title) {
            $title = $this->object->getValue();
        }

        return $this->html->link($url, $title, $attributes);
    }
}
