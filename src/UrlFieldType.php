<?php namespace Anomaly\UrlFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Routing\UrlGenerator;
use Anomaly\UrlFieldType\Validator\ValidUrl;

/**
 * Class UrlFieldType
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class UrlFieldType extends FieldType
{

    /**
     * The URL generator.
     *
     * @var UrlGenerator
     */
    protected $url;

    /**
     * The input class.
     *
     * @var string
     */
    protected $class = 'form-control';

    /**
     * The field type rules.
     *
     * @var array
     */
    protected $rules = [
        'valid_url',
    ];

    /**
     * The field type validators.
     *
     * @var array
     */
    protected $validators = [
        'valid_url' => [
            'handler' => ValidUrl::class,
            'message' => 'anomaly.field_type.url::message.invalid_url',
        ],
    ];

    /**
     * The input view.
     *
     * @var string
     */
    protected $inputView = 'anomaly.field_type.url::input';

    /**
     * Create a new UrlFieldType instance.
     *
     * @param UrlGenerator $url
     */
    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    /**
     * Return the normalized URL.
     *
     * @return bool|string
     */
    public function normalize()
    {
        $value = $this->getValue();

        /**
         * If it's already a URL
         * then we're done here.
         */
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        /**
         * Otherwise try adding
         * a protocol and test that.
         */
        if (filter_var($this->url->getSchema(null) . $value, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED)) {
            return $this->url->getSchema(null) . $value;
        }

        /**
         * Lastly try making it
         * a URL and test that.
         */
        if (filter_var($this->url->to($value), FILTER_VALIDATE_URL)) {
            return $this->url->to($value);
        }

        return $value;
    }
}
