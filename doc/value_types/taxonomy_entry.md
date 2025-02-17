# Taxonomy entry

Generate an instance of `\ErdnaxelaWeb\StaticFakeDesign\Value\TaxonomyEntry` composed of the following properties :

- id (int)
- name (string)
- type (string)
- creationDate (DateTime)
- modificationDate (DateTime)
- fields (array)

## Parameters
- type (string|string[])

When an array is passed in the `type` parameter, a random value within the array will be selected

## Examples
```twig
taxonomy_entry({"type": "tag"})
taxonomy_entry("tag")
taxonomy_entry({"type": ["tag", "category"]})
taxonomy_entry(["tag", "category"])
```

# Taxonomy entry definition

To generate a taxonomy entry, the following parameter need to be defined :

```yaml
erdnaxelaweb.static_fake_design.taxonomy_entry_definition:
    <taxonomy entry type>:
        models: []
        fields:
            <field identifier>:
                required: <true|false>
                type: <field type>
                value: <optional forced value>
                options: []
```

##  List of available fields types and theirs options
- blocks - [see here](block.md)
    - layout
    - allowedTypes (array of blocks types to generate)
- boolean
- content
    - type : type of content - [see here](content.md)
    - max : optional (default 1) - max number of contents to generate
- date
- datetime
- email
- file
- float
    - min : optional
    - max : optional
- form
    - fields : optional (default all) - array of field type that compose the form
- image
- integer
    - min : optional
    - max : optional
- location
- matrix
    - columns : list of columns identifier to compose the matrix
    - minimumRows : optional (default 1)
- richtext
- selection
    - options : list of options to select from
    - isMultiple : optional (default false) - if multiple selection can be selected
- string
    - maxLength: optional (default 255)
- taxonomy_entry
    - type : type of taxonomy entry - [see here](taxonomy_entry.md)
    - max : max number of entries to generate
- text
    - max : optional (default 10) - max number of paragraphes to generate
- time
- url

## Models

The `models` parameter allow to define model data used when generating content.

The parameter is an array of "model" and each model is an associative array where the key if a field identifier and the value the field value.
When generating a content, a random provided model will be used to determine the content fields value.

Example :
```yaml
erdnaxelaweb.static_fake_design.taxonomy_entry_definition:
    element:
        models:
            -
                name: 'Fire'
                logo: 'fire_icon'
            -
                name: 'Water'
                logo: 'water_icon'
            -
                name: 'Wind'
                logo: 'wind_icon'
            -
                name: 'Earth'
                logo: 'earth_icon'
        fields:
            name:
                required: true
                type: string
            logo:
                required: true
                type: string
            description:
                required: true
                type: text
```
