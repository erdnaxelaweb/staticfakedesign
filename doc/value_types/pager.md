# Pager

Generate an instance of `\ErdnaxelaWeb\StaticFakeDesign\Value\Pager` composed of the following properties :

- filters (FormView)
- activeFilters (\Knp\Menu\ItemInterface[])
- maxPerPage (int)
- currentPage (int)
- nbResults (int)
- getHeadlineResults ([\ErdnaxelaWeb\StaticFakeDesign\Value\Content](content.md)[])
- currentPageResults ([\ErdnaxelaWeb\StaticFakeDesign\Value\Content](content.md)[])

## Parameters
- type (string)
- pagesCount (?int)

## Examples
```twig
pager("articles")
```

# Pager definition

To generate a content, the following parameter need to be defined :

```yaml
erdnaxelaweb.static_fake_design.pager_definition:
    <pager type>:
        contentTypes: [<content type identifier>, <content type identifier>]
        filters:
            <filter identifier>:
                type: <filter type>
                options: []
        headlineCount: <number of results in headline>
        maxPerPage: <number of results per page>
        sorts: 
            <sort identifier>:
                type: <sort type>
                options: []

    articles:
        contentTypes: [articles]
        filters:
            category:
                type: checkbox
        maxPerPage: 10
        sorts:
            publish_date:
                type: publish_date
```

## Filter definition

Below is the list of available filters type and options :
- text
- radio
- dropdown
- checkbox
- number
- number_range
- date
- date_range
- bool

## Sort definition

Anything can't be used as a sort type since it's not used by the static templates
