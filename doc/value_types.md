# Value types

The available value types are (some type accept parameters) :
- [audio.md](value_types%2Faudio.md)
- [breadcrumb.md](value_types%2Fbreadcrumb.md)
- [content.md](value_types%2Fcontent.md)
- [coordinates.md](value_types%2Fcoordinates.md)
- [form.md](value_types%2Fform.md)
- [image.md](value_types%2Fimage.md)
- [link.md](value_types%2Flink.md)
- [pager.md](value_types%2Fpager.md)
- [richtext.md](value_types%2Frichtext.md)
- [search_form.md](value_types%2Fsearch_form.md)
- [taxonomy_entry.md](value_types%2Ftaxonomy_entry.md)
- [video.md](value_types%2Fvideo.md)

You can't also use as type the formaters provided by [FakerPHP](https://fakerphp.github.io/)

You can add a `[]` or `[<int>]` at the end of a type to generate an array.

## Create your own value type

Create a service extending `ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator` with the following tag :
```yaml
- {name: 'erdnaxelaweb.static_fake_design.generator', type: '...'}
```

