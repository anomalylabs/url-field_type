# URL Field Type

*anomaly.field_type.url*

#### A URL field type.

The URL field type provides a text input for a URL, a URI path or a named route, with validation and
normalization on the way out.

## Features

- Accepts absolute URLs, relative URI paths, fragments and named routes
- Protocol detection - a bare host is given a scheme on output
- Named route resolution
- Scheme allow-list, configurable per installation
- Link generation helpers on the presenter
- URL component access - scheme, host, path, query

## Accepted Values

The field is deliberately wider than "a URL". All of these are valid and are resolved by
`normalize()` when the value is read:

| Value | Resolves to |
|---|---|
| `https://example.com/a?b=c` | unchanged |
| `example.com` | `http://example.com` (or `https://` on a secure request) |
| `/some-slug` | `http://yoursite.com/some-slug` |
| `some/slug` | `http://yoursite.com/some/slug` |
| `#anchor` | `#anchor` |
| `anomaly.module.users::login` | the URL of that named route |
| `mailto:a@b.com`, `tel:+441234567890` | unchanged |

A named route is resolved first, so a route name always wins over any other interpretation.

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

The input falls back to `http://` when no placeholder is set.

### Allowed Schemes

A value carrying a scheme outside the allow-list is rejected on input and returns `null` from
`normalize()`, so it never reaches an `href`. The default list is:

```php
['http', 'https', 'mailto', 'tel']
```

Values with no scheme - relative paths, fragments, bare hosts and route names - are unaffected.

To change the list, publish the addon's config and edit `schemes.php`:

```php
// resources/config/schemes.php
return [
    'http',
    'https',
    'mailto',
    'tel',
    'ftp',
];
```

The key is `anomaly.field_type.url::schemes`. Note that addon config is not covered by
`php artisan config:cache`, and the packaged default applies if the file cannot be read.

## Accessing Values

### Basic Output

The field returns the stored string:

```php
$entry->website; // https://pyrocms.com
```

```twig
<a href="{{ entry.website }}">Visit Website</a>
```

### Presenter Output

The decorated value - `Anomaly\UrlFieldType\UrlFieldTypePresenter` - adds four methods.

#### link($title = null, $attributes = [])

Returns an anchor for the normalized URL, or `null` when there is no usable value. The title
defaults to the URL itself. Both the URL and the title are entity-encoded by the HTML builder.

```twig
{{ decorated.link('PyroCMS') }}
{{ decorated.link('PyroCMS', {'class': 'btn', 'target': '_blank', 'rel': 'noopener'}) }}
```

#### to($path = null)

Returns the value's scheme, host and port with `$path` appended - the value used as a root URL, so
its own path and query are dropped. Returns `null` when the value has no scheme and host, which is
the case for a fragment, a `mailto:` or a `tel:` value.

```twig
{{ decorated.to('docs') }}   {# https://example.com/docs #}
```

#### parsed($key = null)

Returns `parse_url()` output for the normalized URL, or one component of it.

```twig
{{ decorated.parsed('host') }}
{{ decorated.parsed('path') }}
```

#### query($key = null)

Returns the query string as an array, or one value from it.

```twig
{{ decorated.query('id') }}
```

```php
$id = $decorated->query('id');
```

## Setting Values

### Direct Assignment

```php
$entry->website = 'https://pyrocms.com';
$entry->save();
```

### In Forms

```php
$form = $builder->make('example.module.test');
$form->on('saving', function (FormBuilder $builder) {
    $entry = $builder->getFormEntry();
    $entry->website = 'https://example.com';
});
```

## Database Structure

The URL field type stores the value as written, in a **VARCHAR(255)** column.

## Validation

The field type applies its own `valid_url` rule automatically. It accepts named routes, relative
URIs, fragments and bare hosts, and rejects a value whose scheme is not allowed, an authority URL
without a host, a protocol-relative value and anything carrying whitespace.

Laravel's own rules can be added on top and are stricter.

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

Note `url` requires an absolute URL, so adding it rules out the relative paths, fragments, bare
hosts and route names the field otherwise accepts.

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
```

### Internal Link

```php
'read_more' => [
    'type'   => 'anomaly.field_type.url',
    'config' => [
        'placeholder' => '/about'
    ]
]
```

## Best Practices

1. **Validate Format**: Add `url` where only absolute URLs make sense, and leave it off where
   relative paths are wanted
2. **External Links**: Add `target="_blank"` and `rel="noopener"` for external links
3. **User Guidance**: Provide a placeholder showing the expected format
4. **Display Formatting**: Truncate or format long URLs for display

## Requirements

- Streams Platform ^1.10
- PyroCMS 3.10+

## License

The URL Field Type is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Authors

PyroCMS, Inc. - [https://pyrocms.com](https://pyrocms.com)
Ryan Thompson - [ryan@pyrocms.com](mailto:ryan@pyrocms.com)
