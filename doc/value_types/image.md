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
image({"imageVariationName": "large"})
image("large")
```

# Taxonomy entry definition

To generate image variations, the following parameters need to be defines :<br>
- `erdnaxelaweb.static_fake_design.image.breakpoints: []` is used to define a list of breakpoint
- `erdnaxelaweb.static_fake_design.image.variations: []` is used to define the size of the image for each breakpoint

```yaml
erdnaxelaweb.static_fake_design.image.breakpoints:
    -
        suffix: desktop
        media: '(min-width: 1024px)'
    -
        suffix: tablet
        media: '(min-width: 754px)'
    -
        suffix: mobile
        media: '(min-width: 0)'

erdnaxelaweb.static_fake_design.image.variations:
    large: [ [ 200,200 ], [ 100,100 ], [ 50,50 ] ]
```
