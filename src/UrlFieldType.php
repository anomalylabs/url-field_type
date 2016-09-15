<?php namespace Anomaly\UrlFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

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
     * The input class.
     *
     * @var string
     */
    protected $class = 'form-control';

    /**
     * Base field type rules.
     *
     * @var array
     */
    protected $rules = [
        'url',
    ];

    /**
     * The input view.
     *
     * @var string
     */
    protected $inputView = 'anomaly.field_type.url::input';

}
