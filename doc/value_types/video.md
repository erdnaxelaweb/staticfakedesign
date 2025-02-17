# Video

Generate an instance of `\ErdnaxelaWeb\StaticFakeDesign\Value\Video` composed of the following properties :

- title (string)
- duration (int)
- caption (?string)
- credits (string)
- transcript (string)
- image (?[\ErdnaxelaWeb\StaticFakeDesign\Value\Image](image.md))
- sources (\ErdnaxelaWeb\StaticFakeDesign\Value\VideoSource[])
    - name (string)
    - type (string)
    - uri (string)

## Parameters
- imageVariationName (?string)

## Examples
```twig
video
video({"imageVariationName": "large"})
video("large")
```
