<?php namespace Anomaly\UrlFieldType\Validator;

use Anomaly\UrlFieldType\UrlFieldType;
use Illuminate\Routing\Router;

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
     * Handle the validation.
     *
     * @param               $value
     * @param Router        $router
     * @param UrlFieldType  $fieldType
     * @return bool
     */
    public function handle($value, Router $router, UrlFieldType $fieldType)
    {
        $value = trim($value);

        /**
         * Check if it's a
         * route and use that.
         */
        if ($router->has($value)) {
            return true;
        }

        if ($fieldType->scheme($value)) {

            if (!$fieldType->schemeIsAllowed($value)) {
                return false;
            }

            /**
             * Only a scheme carrying an authority
             * is something filter_var can judge -
             * mailto: and tel: have none.
             */
            if (str_contains($value, '://')) {
                return filter_var($value, FILTER_VALIDATE_URL) !== false
                    && parse_url($value, PHP_URL_HOST) !== null;
            }

            return true;
        }

        /**
         * A protocol relative URL names
         * no scheme for us to check.
         */
        if (str_starts_with($value, '//')) {
            return false;
        }

        /**
         * Otherwise it's a relative URI,
         * a hash, or a bare host - none of
         * which may carry whitespace.
         */
        return !preg_match('/[\x00-\x20\x7f]/', $value);
    }
}
