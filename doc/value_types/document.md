# Document

Generate an instance of `\ErdnaxelaWeb\StaticFakeDesign\Value\Document` which is a collection of values extracted from content source using property paths.

A Document is composed of dynamic fields based on the defined document type configuration.

## Parameters
- type (string): The identifier of the document type to generate

## Examples
```twig
document("user")
document({"type": "user"})
document({"type": "product"})
```

# Document definition

To generate a document, the following parameters need to be defined:

```yaml
static_fake_design:
    document_definition:
        <document type>:
            source: <content type>
            fields:
                id: <property path to id>
                <field name>: <property path>
                # Additional fields...
```

## Fields

Fields define what data is extracted from the sources and how it appears in the final record. Each field uses a property path to extract specific values from the source data.

Property paths support:
- Simple paths: `title`, `author.name`
- Array indexing: `items[0]`
- Wildcards for collections: `tags[*].name` (returns an array of all tag names)

## Example configuration

```yaml
static_fake_design:
    document_definition:
        user:
            sources: user_profile
            fields:
                id: content.id
                username: content.fields.username
                fullName: content.fields.fullName
                email: content.fields.email
                roles: content.fields.roles[*]
        
        product:
            sources: product
            fields:
                id: contentid
                name: contentfields.name
                price: contentfields.price
                tags: contentfields.tags[*].name
```

## Usage in templates

Once defined, documents can be used in templates:

```twig
{% set user = document("user") %}
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
