# Record

Generate an instance of `\ErdnaxelaWeb\StaticFakeDesign\Value\Record` which is a collection of values extracted from external sources using property paths.

A Record is composed of dynamic attributes based on the defined record type configuration. Each record must contain at least an 'id' attribute.

## Parameters
- type (string): The identifier of the record type to generate

## Examples
```twig
record("user")
record({"type": "user"})
record({"type": "product"})
```

# Record definition

To generate a record, the following parameters need to be defined:

```yaml
erdnaxelaweb.static_fake_design.record_definition:
    <record type>:
        sources:
            <source identifier>: <source type>
            # Additional sources...
        attributes:
            id: <property path to id>
            <attribute name>: <property path>
            # Additional attributes...
```

## Sources

Sources define the origin of the data for the record. Each source has a unique identifier and a type that references a content type, taxonomy entry type, or other available data types.

The system uses the source configuration to generate or fetch data, which is then transformed into a record using the attribute mappings.

## Attributes

Attributes define what data is extracted from the sources and how it appears in the final record. Each attribute uses a property path to extract specific values from the source data.

Property paths support:
- Simple paths: `title`, `author.name`
- Array indexing: `items[0]`
- Wildcards for collections: `tags[*].name` (returns an array of all tag names)

The `id` attribute is required for all record definitions.

## Example configuration

```yaml
erdnaxelaweb.static_fake_design.record_definition:
    user:
        sources:
            user: user_profile
        attributes:
            id: user.id
            username: user.fields.username
            fullName: user.fields.fullName
            email: user.fields.email
            roles: user.fields.roles[*]
    
    product:
        sources:
            product: product
            category: product_category
        attributes:
            id: product.id
            name: product.fields.name
            price: product.fields.price
            categoryName: category.fields.name
            tags: product.fields.tags[*].name
```

## Usage in templates

Once defined, records can be used in templates:

```twig
{% set user = record("user") %}
<div class="user-card">
    <h3>{{ user.fullName }}</h3>
    <p>{{ user.email }}</p>
    <div class="roles">
        {% for role in user.roles %}
            <span class="role">{{ role }}</span>
        {% endfor %}
    </div>
</div>
```
