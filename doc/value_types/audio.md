# Audio

Generate an instance of `\ErdnaxelaWeb\StaticFakeDesign\Value\Audio` composed of the following properties :

- title (string)
- image (?[\ErdnaxelaWeb\StaticFakeDesign\Value\Image](image.md))
- source (?\ErdnaxelaWeb\StaticFakeDesign\Value\AudioSource)
    - name (string)
    - size (int)
    - type (string)
    - uri (string)

## Parameters
- imageVariationName (?string)

## Examples
```twig
audio
audio({"imageVariationName": "large"})
audio("large")
```
