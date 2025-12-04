# URL Field Type

*anomaly.field_type.url*

#### A URL field type.

The URL field type provides an HTML input with built-in URL validation and formatting.

## Features

- HTML5 URL input type
- Automatic URL validation
- Protocol detection and normalization
- Support for relative and absolute URLs
- Link generation helpers
- Target attribute configuration
- Custom validation rules
- Database storage optimization

## Configuration

### Basic Configuration

```php
protected $fields = [
    'website' => [
        'type' => 'anomaly.field_type.url'
    ]
];
```

### With Placeholder

```php
'link' => [
    'type'   => 'anomaly.field_type.url',
    'config' => [
        'placeholder' => 'https://example.com'
    ]
]
```

### With Default Protocol

```php
'website' => [
    'type'   => 'anomaly.field_type.url',
    'config' => [
        'default_protocol' => 'https'
    ]
]
```

## Usage Examples

### Basic URL Field

```php
$stream->create([
    'website' => 'https://pyrocms.com'
]);
```

### With Validation

```php
protected $fields = [
    'homepage' => [
        'type'  => 'anomaly.field_type.url',
        'rules' => [
            'required'
        ]
    ]
];
```

## Accessing Values

### In Twig Templates

```twig
{# Display as link #}
<a href="{{ entry.website }}">Visit Website</a>

{# Display with target blank #}
<a href="{{ entry.website }}" target="_blank" rel="noopener">
    {{ entry.website }}
</a>

{# Check if URL exists #}
{% if entry.website %}
    <a href="{{ entry.website }}">Link</a>
{% endif %}

{# Display domain only #}
{{ entry.website|parse_url(constant('PHP_URL_HOST')) }}
```

### In PHP

```php
$entry = $model->find(1);

// Get URL
$url = $entry->website;

// Parse URL components
$parsed = parse_url($entry->website);
$domain = $parsed['host'];
$scheme = $parsed['scheme'];

// Check if URL is external
$isExternal = !str_contains($entry->website, config('app.url'));
```

## Setting Values

### In Forms

```php
$form = $builder->make('example.module.test');
$form->on('saving', function(FormBuilder $builder) {
    $entry = $builder->getFormEntry();
    $entry->website = 'https://example.com';
});
```

### Direct Assignment

```php
$entry->website = 'https://pyrocms.com';
$entry->save();
```

## Database Structure

The URL field type stores URLs as:
- **VARCHAR(255)** - The complete URL string

## Validation

### Required URL

```php
'website' => [
    'type'  => 'anomaly.field_type.url',
    'rules' => [
        'required',
        'url'
    ]
]
```

### Active URL (DNS Check)

```php
'homepage' => [
    'type'  => 'anomaly.field_type.url',
    'rules' => [
        'required',
        'active_url'
    ]
]
```

### HTTPS Only

```php
'secure_link' => [
    'type'  => 'anomaly.field_type.url',
    'rules' => [
        'required',
        'url',
        'regex:/^https:\/\//'
    ]
]
```

## Common Use Cases

### Website URL

```php
'website' => [
    'type'   => 'anomaly.field_type.url',
    'config' => [
        'placeholder' => 'https://yourwebsite.com'
    ],
    'rules' => [
        'url'
    ]
]
```

### Social Media Links

```php
'facebook_url' => [
    'type'   => 'anomaly.field_type.url',
    'config' => [
        'placeholder' => 'https://facebook.com/yourpage'
    ],
    'rules' => [
        'url',
        'regex:/^https:\/\/(www\.)?facebook\.com\//'
    ]
]

'twitter_url' => [
    'type'   => 'anomaly.field_type.url',
    'config' => [
        'placeholder' => 'https://twitter.com/yourusername'
    ],
    'rules' => [
        'url',
        'regex:/^https:\/\/(www\.)?twitter\.com\//'
    ]
]
```

### Documentation Link

```php
'docs_url' => [
    'type'   => 'anomaly.field_type.url',
    'config' => [
        'placeholder' => 'https://docs.example.com'
    ]
]
```

### External Resource

```php
'external_link' => [
    'type'   => 'anomaly.field_type.url',
    'config' => [
        'default_protocol' => 'https'
    ],
    'rules' => [
        'required',
        'url'
    ]
]
```

## Best Practices

1. **Validate Format**: Always use URL validation rules
2. **Normalize URLs**: Store URLs with consistent protocols (http/https)
3. **External Links**: Add `target="_blank"` and `rel="noopener"` for external links
4. **Secure Links**: Prefer HTTPS URLs when possible
5. **User Guidance**: Provide clear placeholders showing expected format
6. **Link Checking**: Consider implementing periodic link validation
7. **Display Formatting**: Truncate or format long URLs for display

## Requirements

- Streams Platform ^1.10
- PyroCMS 3.10+

## License

The URL Field Type is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Authors

PyroCMS, Inc. - [https://pyrocms.com](https://pyrocms.com)
Ryan Thompson - [ryan@pyrocms.com](mailto:ryan@pyrocms.com)
