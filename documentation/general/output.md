# Output

This field type returns the value as it's stored in the database by default.

### Query

Return the parsed query string.

Optionally a key may be provided if you want a specific query parameter.

```
// Twig usage
{{ entry.example.query('key') }}

// API usage
$entry->example->query('key');
```

### Parsed

Return the parsed URL. See available [parsed output](http://php.net/manual/en/function.parse-url.php).

```
// Twig usage
{{ entry.example.parsed.host }} // Outputs www.anomaly.is

// API usage
$entry->example->parsed->host; // Outputs www.anomaly.is
```

### Link

`title` - The title of the link. If none is provided the URL will be used.

`attributes` - The HTML attributes as an array. No attributes are set by default.

Return am HTML anchor to the URL.

```
// Twig usage
{{ entry.example.link('AnomalyLabs, Inc.', {'target': '_blank'})|raw }}

// API usage
$entry->example->link('AnomalyLabs, Inc.', ['target' => '_blank']);
```
