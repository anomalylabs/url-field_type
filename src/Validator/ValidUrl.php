<?php namespace Anomaly\UrlFieldType\Validator;

use Anomaly\Streams\Platform\Routing\UrlGenerator;
use Anomaly\UrlFieldType\UrlFieldType;

/**
 * Class ValidUrl
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ValidUrl
{

    /**
     * The URL generator.
     *
     * @var UrlGenerator
     */
    protected $url;

    /**
     * Create a new ValidUrl instance.
     *
     * @param UrlGenerator $url
     */
    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    /**
     * Handle the validation.
     *
     * @param $value
     * @return bool
     */
    public function handle($value, UrlFieldType $type)
    {

        /**
         * If it matches now
         * then we're done here.
         */
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return true;
        }

        /**
         * Otherwise try adding
         * a protocol and test that.
         */
        if (filter_var('http://' . $value, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED)) {
            return true;
        }

        /**
         * Lastly try making it
         * a URL and test that.
         */
        if (filter_var($this->url->to($value), FILTER_VALIDATE_URL)) {
            return true;
        }

        return false;
    }
}
