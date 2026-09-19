<?php namespace Anomaly\UrlFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;
use Anomaly\Streams\Platform\Routing\UrlGenerator;
use Anomaly\UrlFieldType\Validator\ValidUrl;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

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
     * The request object.
     *
     * @var Request
     */
    protected $request;

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
     * The default allowed URL schemes.
     *
     * @var array
     */
    protected $schemes = [
        'http',
        'https',
        'mailto',
        'tel',
    ];

    /**
     * The input view.
     *
     * @var string
     */
    protected $inputView = 'anomaly.field_type.url::input';

    /**
     * The router utility.
     *
     * @var Router
     */
    protected $router;

    /**
     * Create a new UrlFieldType instance.
     *
     * @param UrlGenerator $url
     * @param Router       $router
     * @param Request      $request
     */
    public function __construct(UrlGenerator $url, Router $router, Request $request)
    {
        $this->url     = $url;
        $this->router  = $router;
        $this->request = $request;
    }

    /**
     * Return the normalized URL.
     *
     * @return string|null
     */
    public function normalize()
    {
        if (!$value = $this->getValue()) {
            return null;
        }

        /**
         * If the value is a route
         * then let's use that
         * first and foremost.
         */
        if ($this->router->has($value)) {
            return $this->url->route($value);
        }

        /**
         * Anything carrying a scheme
         * we don't allow stops here.
         */
        if (!$this->schemeIsAllowed($value)) {
            return null;
        }

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
        if (filter_var('http://' . $value, FILTER_VALIDATE_URL) && str_contains($value, '.')) {
            return ($this->request->isSecure() ? 'https://' : 'http://') . $value;
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

    /**
     * Return the allowed URL schemes.
     *
     * @return array
     */
    public function getSchemes()
    {
        return array_map('strtolower', (array)config('anomaly.field_type.url::schemes', $this->schemes));
    }

    /**
     * Return the scheme of a value.
     *
     * Browsers ignore control characters within
     * a scheme so they are stripped before it
     * is read back out of the value.
     *
     * @param  string $value
     * @return string|null
     */
    public function scheme($value)
    {
        $value = preg_replace('/[\x00-\x20\x7f]/', '', (string)$value);

        return preg_match('/^([a-z][a-z0-9+.\-]*):/i', $value, $matches) ? $matches[1] : null;
    }

    /**
     * Return whether a value's scheme is allowed.
     *
     * Values without a scheme are relative
     * and are left to the caller.
     *
     * @param  string $value
     * @return bool
     */
    public function schemeIsAllowed($value)
    {
        if (!$scheme = $this->scheme($value)) {
            return true;
        }

        return in_array(strtolower($scheme), $this->getSchemes());
    }

}
