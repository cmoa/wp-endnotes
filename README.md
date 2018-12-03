# WP ENDNOTES v1.2.1

## About

WP Endnotes is a simple WordPress plugin that provides a shortcode for creating footnotes in post content.

To use, activate the plugin, then wrap any footnote text within a `[ref]` shortcode tag. Footnote links and numbers are managed automatically.

**Example:**

Our product has been shown to help hundreds of people.[ref]Data on file.[/ref]

...

**Will output:**

Our product has been shown to help hundreds of people.<sup>1</sup>

...

<small>1. Data on file</small>

## Dependencies

Mustache/Mustache ~2.5 (included)
