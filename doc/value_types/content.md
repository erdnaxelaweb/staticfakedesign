# Content

Generate an instance of `\ErdnaxelaWeb\StaticFakeDesign\Value\Content` composed of the following properties :

- id (int)
- name (string)
- type (string)
- creationDate (DateTime)
- modificationDate (DateTime)
- fields (array)
- url (string)
- breadcrumb ([\ErdnaxelaWeb\StaticFakeDesign\Value\Breadcrumb](breadcrumb.md))

## Parameters
- type (string|string[])

When an array is passed in the `type` parameter, a random value within the array will be selected

## Examples
```twig
content({"type": "article"})
content("article")
content({"type": ["article", "press_release"]})
content(["article", "press_release"])
```

# Content definition

To generate a content, the following parameter need to be defined :

```yaml
erdnaxelaweb.static_fake_design.content_definition:
    <content type>:
        models: []
        fields:
            <field identifier>:
                required: <true|false>
                type: <field type>
                value: <optional forced value>
                options: []
```

##  List of available fields types and theirs options
<ul>
    <li>blocks
        <ul>
            <li>allowedTypes (array of blocks types to generate - see <a href="/static/examples/block">here</a>)
            </li>
        </ul>
    </li>
    <li>boolean</li>
    <li>content
        <ul>
            <li>type : type of content - see <a href="/static/examples/content">here</a></li>
            <li>max : optional (default 1) - max number of contents to generate</li>
        </ul>
    </li>
    <li>date</li>
    <li>datetime</li>
    <li>email</li>
    <li>file</li>
    <li>float
        <ul>
            <li>min : optional</li>
            <li>max : optional</li>
        </ul>
    </li>
    <li>form
        <ul>
            <li>fields : optional (default all) - array of field type that compose the form</li>
        </ul>
    </li>
    <li>image</li>
    <li>integer
        <ul>
            <li>min : optional</li>
            <li>max : optional</li>
        </ul>
    </li>
    <li>location</li>
    <li>matrix
        <ul>
            <li>columns : list of columns identifier to compose the matrix</li>
            <li>minimumRows : optional (default 1)</li>
        </ul>
    </li>
    <li>richtext</li>
    <li>selection
        <ul>
            <li>options : list of options to select from</li>
            <li>isMultiple : optional (default false) - if multiple selection can be selected</li>
        </ul>
    </li>
    <li>string
        <ul>
            <li>maxLength: optional (default 255)</li>
        </ul>
    </li>
    <li>taxonomy_entry
        <ul>
            <li>type : type of taxonomy entry - see <a href="/static/examples/taxonomy-entry">here</a></li>
            <li>max : max number of entries to generate</li>
        </ul>
    </li>
    <li>text
        <ul>
            <li>max : optional (default 10) - max number of paragraphes to generate</li>
        </ul>
    </li>
    <li>time</li>
</ul>

## Models

The `models` parameter allow to define model data used when generating content.

The parameter is an array of "model" and each model is an associative array where the key if a field identifier and the value the field value.
When generating a content, a random provided model will be used to determine the content fields value.

Example :
```yaml
erdnaxelaweb.static_fake_design.content_definition:
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
