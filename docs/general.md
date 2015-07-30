# URL Field Type

- [Introduction](#introduction)
- [Configuration](#configuration)
- [Output](#output)


<a name="introduction"></a>
## Introduction

`anomaly.field_type.url`

The URL field type provides a simple HTML input restricting input to URLs.


<a name="configuration"></a>
## Configuration

**Example Definition:**

    protected $fields = [
        'example' => [
            'type'   => 'anomaly.field_type.url',
            'config' => [
                'default_value' => 'http://www.anomaly.is'
            ]
        ]
    ];

### `default_value`

The default value of the URL field.


<a name="output"></a>
## Output

This field type returns the value as it's stored in the database by default.

### `query($key = null)`

`$key` - The query value to return. If none is provided the entire query array is returned.

Return the parsed query string.

    // Twig usage
    {{ entry.example.query('key') }} or {{ entry.example.query.key }} 
    
    // API usage
    $entry->example->query('key'); or $entry->example->query['key']

### `parsed()`

Returns the parsed URL. See available [parsed output](http://php.net/manual/en/function.parse-url.php).

    // Twig usage
    {{ entry.example.parsed.host }} // Outputs www.anomaly.is
    
    // API usage
    $entry->example->parsed->host; // Outputs www.anomaly.is

### `link($title = null, array $attributes = [])`

`$title` - The link title. If none is provided the URL will be used.

`$attributes` - The HTML attributes as an array. No attributes are set by default.

Returns an HTML anchor to the URL.

    // Twig usage
    {{ entry.example.link('AnomalyLabs, Inc.', {'target': '_blank'})|raw }}
    
    // API usage
    $entry->example->link('AnomalyLabs, Inc.', ['target' => '_blank']);
