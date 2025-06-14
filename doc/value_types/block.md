# Content

Generate an instance of `\ErdnaxelaWeb\StaticFakeDesign\Value\Block` composed of the following properties :

- id (int)
- name (string)
- type (string)
- view (string)
- attributes (array)

## Parameters
- type (string|string[])
- view (string|null)

When an array is passed in the `type` parameter, a random value within the array will be selected

## Examples
```twig
block({"type": "article", "view": "default"})
block("article", "default")
block({"type": ["article", "press_release"], "view": "default"})
block(["article", "press_release"], "default")
```

# Block definition

To generate a block, the following parameter need to be defined :

```yaml
static_fake_design:
    block_definition:
        <block type>:
            models: []
            views:
                <view identifier>: <template path>
            attributes:
                <attribute identifier>:
                    required: <true|false>
                    type: <field type>
                    value: <optional forced value>
                    options: []
```
##  List of available fields types and theirs options
- boolean
- content
    - type : type of content - [see here](content.md)
    - max : optional (default 1) - max number of contents to generate
- integer
    - min : optional
    - max : optional
- richtext
- selection
    - options : list of options to select from
    - isMultiple : optional (default false) - if multiple selection can be selected
- string
    - maxLength: optional (default 255)
- text
    - max : optional (default 10) - max number of paragraphes to generate
- time
- url

## Support new attribute types

You can extend the available field types by creating and registering your own custom field generators within your own project or bundle, without modifying the `StaticFakeDesignBundle` itself.

Follow these steps:

1.  **Create an Attribute generator class:**
    *   Create a new PHP class to implement the `ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute\Field\AttributeGeneratorInterface` or extend the `ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute\AbstractAttributeGenerator` abstract class.
    *   Implement the `__invoke` methods to define the logic for generating fake data for your custom field type.

2.  **Register as a Symfony service:**
    *   Define a new service for your generator class.
    *   Tag your service definition with `erdnaxelaweb.static_fake_design.generator.block_field`.
    *   Add the `type` attribute to the tag, assigning a unique string identifier for your new field type. This identifier is what you will use in the `static_fake_design.block_definition` YAML configuration within your project.

**Example Service Definition (in `config/services.yaml`):**

```yaml
services:
    App\Fake\AttributeGenerator\MyCustomFieldGenerator:
        tags:
            - {name: 'erdnaxelaweb.static_fake_design.generator.block_field', type: 'my_custom_field'}
```

## Models

The `models` parameter allow to define model data used when generating content.

The parameter is an array of "model" and each model is an associative array where the key if a field identifier and the value the field value.
When generating a content, a random provided model will be used to determine the content fields value.

Example :
```yaml
static_fake_design:
    block_definition:
        element:
            views:
                default: 'block/elements/default.html.twig'
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
            attributes:
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

# Layout definition

To use the content "blocks" field type you also need to define the following parameter :

```yaml
static_fake_design:
    block_layout_definition:
        <layout identifier>:
            template: <template path>
            zones:
                - <zone identifier>
            sections:
                <section identifier>:
                    blocks: 
                        - <block type>
                        - <block type>/<view type>
                    template: <section template path>
```

The sections of a layout allow to group block together when they are following each other based on there type and view.\
The `default` section will be used when there is no other section matched.\
In your layout template you can then use the twig filter `group_blocks_by_section` to groups a list of blocks.

## Example
Considering the following layout :

```yaml
static_fake_design:
    block_layout_definition:
        default:
            template: layout/default.html.twig
            zones:
                - default
            sections:
                default:
                    blocks: []
                    template: layout/section/default.html.twig
                slider:
                    blocks: 
                        - article/slider
                    template: layout/section/slider.html.twig
```

And having the following array of block in our default zone :
````twig
[
    article,
    article/slider,
    article/slider,
    article,
    article/slider,
]
````

Using `layout.zones[0].blocks|group_blocks_by_section(layout)` will return the following list :

````twig
[
    [
        identifier: 'default',
        template: 'layout/section/default.html.twig',
        blocks: [
            article
        ],
    ],
    [
        identifier: 'slider',
        template: 'layout/section/slider.html.twig',
        blocks: [
            article/slider,
            article/slider
        ],
    ],
    [
        identifier: 'default',
        template: 'layout/section/default.html.twig',
        blocks: [
            article
        ],
    ],
    [
        identifier: 'slider',
        template: 'layout/section/slider.html.twig',
        blocks: [
            article/slider
        ],
    ]
]
````
