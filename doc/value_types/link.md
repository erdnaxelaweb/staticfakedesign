# Link

Generate an instance of `\Knp\Menu\ItemInterface` composed of the following properties :
- name (string)
- linkAttributes (array)
- childrenAttributes (array)
- labelAttributes (array)
- uri (string)
- attributes (array)
- extras (array)
- display (boolean)
- displayChildren (boolean)
- children (array)
- parent (null)
- isCurrent (null)

## Parameters
- target (?string)

## Examples
```twig
link
link({'target': '_blank'})
link('_blank')
```
