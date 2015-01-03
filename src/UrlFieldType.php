<?php namespace Anomaly\UrlFieldType;

use Anomaly\Streams\Platform\Addon\FieldType\FieldType;

/**
 * Class UrlFieldType
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Addon\FieldType\Url
 */
class UrlFieldType extends FieldType
{

    /**
     * Base field type rules.
     *
     * @var array
     */
    protected $rules = ['url'];

    /**
     * Get view data for the input.
     *
     * @return array
     */
    public function getInputData()
    {
        $data = parent::getInputData();

        $data['type'] = 'url';

        return $data;
    }
}
