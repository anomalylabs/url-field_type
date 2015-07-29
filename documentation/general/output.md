# Output

This field type returns a URL

### Query

Return the parsed query string.  
Optionally a key may be provided if you want a specific query parameter.

```
// Twig usage
{{ entry.example.query($key) }}

// API usage
$entry->example->query($key);
```

### Parsed

Return the parsed URL.  
[Parsed Output](http://php.net/manual/en/function.parse-url.php)

```
// Twig usage
{{ entry.example.parsed }}

// API usage
$entry->example->parsed;
```

### Link

Return a html link.  
Optionally a title and attributes array may be passed in.

```
// Twig usage
{{ entry.example.link($title, {'class': 'example}) }}

$entry->example->link($title, ['class' => 'example']);
```
