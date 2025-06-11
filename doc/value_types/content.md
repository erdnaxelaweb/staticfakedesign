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
static_fake_design:
    content_definition:
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
- blocks - [see here](block.md)
    - layout
    - allowedTypes (array of blocks types to generate)
- boolean
- content
    - type : type of content - [see here](content.md)
    - max : optional (default 1) - max number of contents to generate
- date
- datetime
- email
- file
- float
    - min : optional
    - max : optional
- form
    - fields : optional (default all) - array of field type that compose the form
- image
- integer
    - min : optional
    - max : optional
- location
- matrix
    - columns : list of columns identifier to compose the matrix
    - minimumRows : optional (default 1)
- richtext
- selection
    - options : list of options to select from
    - isMultiple : optional (default false) - if multiple selection can be selected
- string
    - maxLength: optional (default 255)
- svg
    - width : optional (default 200) - width of the SVG
    - height : optional (default 200) - height of the SVG
    - numShapes : optional (default 10) - number of shapes to generate
- taxonomy_entry
    - type : type of taxonomy entry - [see here](taxonomy_entry.md)
    - max : max number of entries to generate
- text
    - max : optional (default 10) - max number of paragraphes to generate
- time
- url
- pager
  - type : the pager type
- expression
  - expression : https://symfony.com/doc/current/reference/formats/expression_language.html

## Support new field types

You can extend the available field types by creating and registering your own custom field generators within your own project or bundle, without modifying the `StaticFakeDesignBundle` itself.

Follow these steps:

1.  **Create a Field generator class:**
    *   Create a new PHP class to implement the `ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\FieldGeneratorInterface` or extend the `ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\AbstractFieldGenerator` abstract class.
    *   Implement the `__invoke` methods to define the logic for generating fake data for your custom field type.

2.  **Register as a Symfony service:**
    *   Define a new service for your generator class.
    *   Tag your service definition with `erdnaxelaweb.static_fake_design.generator.content_field`.
    *   Add the `type` attribute to the tag, assigning a unique string identifier for your new field type. This identifier is what you will use in the `static_fake_design.content_definition` YAML configuration within your project.

**Example Service Definition (in `config/services.yaml`):**

```yaml
services:
    App\Fake\FieldGenerator\MyCustomFieldGenerator:
        tags:
            - {name: 'erdnaxelaweb.static_fake_design.generator.content_field', type: 'my_custom_field'}
```

## Models

The `models` parameter allow you to create variations of your content with specific data.

The parameter is an array of "model" and each model is an associative array where the key if a field identifier and the value the field value.
When generating a content, a random configured model will be used to determine the content fields value.

Example :
```yaml
static_fake_design:
    content_definition:
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

## Complete reference example
```yaml
static_fake_design:
    content_definition:
        comprehensive_example:
            name:
                eng-GB: 'Comprehensive Example'
                fre-FR: 'Exemple Complet'
            description:
                eng-GB: 'A comprehensive example showcasing all field types and options'
                fre-FR: 'Un exemple complet présentant tous les types de champs et options'
            nameSchema: '<title>'
            urlAliasSchema: '<title>'
            defaultAlwaysAvailable: true
            defaultSortField: published
            defaultSortOrder: desc
            container: false
            # Models provide predefined sets of values that can be used when generating content
            models:
                -
                    title: 'Model Example 1'
                    string_field: 'Predefined string for model 1'
                    integer_field: 42
                -
                    title: 'Model Example 2'
                    string_field: 'Predefined string for model 2'
                    integer_field: 100
            fields:
                # Basic field types
                title:
                    name: 
                        eng-GB: 'Title'
                        fre-FR: 'Titre'
                    description: 
                        eng-GB: 'The main title of the content'
                        fre-FR: 'Le titre principal du contenu'
                    type: string
                    options:
                        maxLength: 255
                    required: true
                    searchable: true
                    translatable: true
                    category: Basic Information
                
                subtitle:
                    name: 
                        eng-GB: 'Subtitle'
                        fre-FR: 'Sous-titre'
                    description: 
                        eng-GB: 'A secondary title'
                        fre-FR: 'Un titre secondaire'
                    type: string
                    options: {}
                    required: false
                    searchable: true
                    translatable: true
                    category: Basic Information
                
                summary:
                    name: 
                        eng-GB: 'Summary'
                        fre-FR: 'Résumé'
                    description: 
                        eng-GB: 'A brief summary of the content'
                        fre-FR: 'Un bref résumé du contenu'
                    type: text
                    options:
                        max: 5  # Max number of paragraphs to generate
                    required: true
                    searchable: true
                    translatable: true
                    category: Content
                
                # Rich content fields
                body:
                    name: 
                        eng-GB: 'Body'
                        fre-FR: 'Corps'
                    description: 
                        eng-GB: 'The main content body'
                        fre-FR: 'Le corps principal du contenu'
                    type: richtext
                    options: {}
                    required: true
                    searchable: true
                    translatable: true
                    category: Content
                
                # Date and time fields
                publication_date:
                    name: 
                        eng-GB: 'Publication Date'
                        fre-FR: 'Date de publication'
                    description: 
                        eng-GB: 'When the content was published'
                        fre-FR: 'Quand le contenu a été publié'
                    type: date
                    options: {}
                    required: true
                    searchable: true
                    translatable: false
                    category: Metadata
                
                event_datetime:
                    name: 
                        eng-GB: 'Event Date and Time'
                        fre-FR: 'Date et heure de l\'événement'
                    description: 
                        eng-GB: 'When the event takes place'
                        fre-FR: 'Quand l\'événement a lieu'
                    type: datetime
                    options: {}
                    required: false
                    searchable: true
                    translatable: false
                    category: Event Details
                
                event_time:
                    name: 
                        eng-GB: 'Event Time'
                        fre-FR: 'Heure de l\'événement'
                    description: 
                        eng-GB: 'The time when the event starts'
                        fre-FR: 'L\'heure à laquelle l\'événement commence'
                    type: time
                    options: {}
                    required: false
                    searchable: false
                    translatable: false
                    category: Event Details
                
                # Numeric fields
                integer_field:
                    name: 
                        eng-GB: 'Integer Value'
                        fre-FR: 'Valeur entière'
                    description: 
                        eng-GB: 'A whole number value'
                        fre-FR: 'Une valeur nombre entier'
                    type: integer
                    options:
                        min: 0
                        max: 1000
                    required: false
                    searchable: false
                    translatable: false
                    category: Numeric Data
                
                float_field:
                    name: 
                        eng-GB: 'Float Value'
                        fre-FR: 'Valeur décimale'
                    description: 
                        eng-GB: 'A decimal number value'
                        fre-FR: 'Une valeur nombre décimal'
                    type: float
                    options:
                        min: 0.0
                        max: 100.0
                    required: false
                    searchable: false
                    translatable: false
                    category: Numeric Data
                
                # Boolean field
                is_featured:
                    name: 
                        eng-GB: 'Is Featured'
                        fre-FR: 'Est mis en avant'
                    description: 
                        eng-GB: 'Whether this content should be featured'
                        fre-FR: 'Si ce contenu doit être mis en avant'
                    type: boolean
                    options: {}
                    required: false
                    searchable: false
                    translatable: false
                    category: Display Options
                
                # Media fields
                main_image:
                    name: 
                        eng-GB: 'Main Image'
                        fre-FR: 'Image principale'
                    description: 
                        eng-GB: 'The primary image for this content'
                        fre-FR: 'L\'image principale pour ce contenu'
                    type: image
                    options: {}
                    required: true
                    searchable: false
                    translatable: false
                    category: Media
                
                attachment:
                    name: 
                        eng-GB: 'Attachment'
                        fre-FR: 'Pièce jointe'
                    description: 
                        eng-GB: 'A file attachment'
                        fre-FR: 'Une pièce jointe'
                    type: file
                    options: {}
                    required: false
                    searchable: false
                    translatable: false
                    category: Media
    
                svg:
                    name:
                        eng-GB: 'SVG'
                        fre-FR: 'SVG'
                    description:
                        eng-GB: ''
                        fre-FR: ''
                    type: svg
                    options:
                        width: 200
                        height: 200
                        numShapes: 10
                    required: false
                    searchable: false
                    translatable: true
                    category: Media
                
                # Selection field
                category:
                    name: 
                        eng-GB: 'Category'
                        fre-FR: 'Catégorie'
                    description: 
                        eng-GB: 'The category of this content'
                        fre-FR: 'La catégorie de ce contenu'
                    type: selection
                    options:
                        options:
                            - 'News'
                            - 'Event'
                            - 'Article'
                            - 'Press Release'
                        isMultiple: false
                    required: true
                    searchable: true
                    translatable: false
                    category: Classification
                
                tags:
                    name: 
                        eng-GB: 'Tags'
                        fre-FR: 'Tags'
                    description: 
                        eng-GB: 'Tags for this content'
                        fre-FR: 'Tags pour ce contenu'
                    type: selection
                    options:
                        options:
                            - 'Technology'
                            - 'Business'
                            - 'Science'
                            - 'Health'
                            - 'Sports'
                            - 'Arts'
                        isMultiple: true
                    required: false
                    searchable: true
                    translatable: false
                    category: Classification
                
                # Reference fields
                related_content:
                    name: 
                        eng-GB: 'Related Content'
                        fre-FR: 'Contenu associé'
                    description: 
                        eng-GB: 'Other content items related to this one'
                        fre-FR: 'Autres contenus liés à celui-ci'
                    type: content
                    options:
                        type: ['article', 'news']
                        max: 5
                    required: false
                    searchable: false
                    translatable: false
                    category: References
                
                taxonomy:
                    name: 
                        eng-GB: 'Taxonomy'
                        fre-FR: 'Taxonomie'
                    description: 
                        eng-GB: 'Taxonomy entries for this content'
                        fre-FR: 'Entrées de taxonomie pour ce contenu'
                    type: taxonomy_entry
                    options:
                        type: 'topic'
                        max: 10
                    required: false
                    searchable: true
                    translatable: false
                    category: Classification
                
                # Contact fields
                contact_email:
                    name: 
                        eng-GB: 'Contact Email'
                        fre-FR: 'Email de contact'
                    description: 
                        eng-GB: 'Email address for inquiries'
                        fre-FR: 'Adresse email pour les demandes'
                    type: email
                    options: {}
                    required: false
                    searchable: false
                    translatable: false
                    category: Contact Information
                
                website:
                    name: 
                        eng-GB: 'Website'
                        fre-FR: 'Site web'
                    description: 
                        eng-GB: 'Related website URL'
                        fre-FR: 'URL du site web associé'
                    type: url
                    options: {}
                    required: false
                    searchable: false
                    translatable: false
                    category: Contact Information
                
                location:
                    name: 
                        eng-GB: 'Location'
                        fre-FR: 'Emplacement'
                    description: 
                        eng-GB: 'Physical location'
                        fre-FR: 'Emplacement physique'
                    type: location
                    options: {}
                    required: false
                    searchable: true
                    translatable: false
                    category: Contact Information
                
                # Complex fields
                page_builder:
                    name: 
                        eng-GB: 'Page Builder'
                        fre-FR: 'Constructeur de page'
                    description: 
                        eng-GB: 'Build the page with blocks'
                        fre-FR: 'Construire la page avec des blocs'
                    type: blocks
                    options:
                        layout: default
                        allowedTypes:
                            - 'text_block'
                            - 'image_block'
                            - 'gallery_block'
                            - 'quote_block'
                            - 'video_block'
                    required: false
                    searchable: true
                    translatable: true
                    category: Page Builder
                
                pricing_table:
                    name: 
                        eng-GB: 'Pricing Table'
                        fre-FR: 'Tableau des prix'
                    description: 
                        eng-GB: 'A matrix of pricing options'
                        fre-FR: 'Une matrice d\'options de prix'
                    type: matrix
                    options:
                        columns:
                            - 'plan_name'
                            - 'price'
                            - 'features'
                            - 'is_popular'
                        minimumRows: 3
                    required: false
                    searchable: false
                    translatable: true
                    category: Pricing
                
                contact_form:
                    name: 
                        eng-GB: 'Contact Form'
                        fre-FR: 'Formulaire de contact'
                    description: 
                        eng-GB: 'Form for user inquiries'
                        fre-FR: 'Formulaire pour les demandes des utilisateurs'
                    type: form
                    options:
                        fields:
                            - 'name'
                            - 'email'
                            - 'subject'
                            - 'message'
                    required: false
                    searchable: false
                    translatable: true
                    category: Forms
    
                pager:
                    name:
                        eng-GB: 'Related contents'
                        fre-FR: 'A lire aussi'
                    description:
                        eng-GB: 'Related content list'
                        fre-FR: 'Liste de contenu a lire aussi'
                    type: pager
                    options:
                        type: 'related_content'
                    required: false
                    searchable: false
                    translatable: true
                    category: Pager
    
                expression:
                    name:
                        eng-GB: 'Related contents title'
                        fre-FR: 'A lire aussi'
                    description:
                        eng-GB: 'Related content list'
                        fre-FR: 'Liste de contenu a lire aussi'
                    type: expression
                    options:
                        expression: 'content.fields.pager[*].name'
                    required: false
                    searchable: false
                    translatable: true
                    category: Expression
```

