# Static Fake Design Bundle

The core purpose of this bundle is to generate realistic-looking static HTML/CSS/JS based on fake data. \
It aims to save developers and designers time by providing a visual representation of their application with placeholder content, even before the backend is fully built by providing tools to:

StaticFakeDesignBundle is a Symfony bundle designed to streamline the development of UI components and templates with auto-generated fake data. It bridges the gap between design and development by providing tools to:

- Generate realistic fake data for UI prototyping
- Define reusable components with typed parameters
- View components in an integrated showroom interface
- Create static versions of templates for demonstration purposes

This bundle is particularly useful for frontend development, to streamline the development of UI components and templates.

## Table of Contents

- [Installation](#installation)
- [Features](#features)
  - [Showroom Interface](#showroom)
  - [Static Template Rendering](#static-version-of-a-template)
- [Usage](#usage)
  - [Fake Data Generation](#fake-data-generation)
  - [Component Declaration](#component-declaration)
  - [Service Integration](#symfony-service)
- [Complex Value Objects](#complex-value-objects)
  - [Content Definitions](#content-definitions)
  - [Taxonomy Entry Definitions](#taxonomy-entry-definitions)
  - [Pager Definitions](#pager-definitions)
  - [Block Definitions](#block-definitions)
  - [Layout Definitions](#layout-definitions)
- [Documentation](#documentation)
- [Contributing](#contributing)
- [License](#license)

## Installation

1. First, require the package using Composer:

```bash
composer require erdnaxelaweb/staticfakedesign:dev-main
```

2. Add the bundle to your config/bundles.php file:
```php
return [
    // ...
    ErdnaxelaWeb\StaticFakeDesignBundle\StaticFakeDesignBundle::class => ['all' => true],
];
```

## Features

### Fake Data Generation
The bundle provides a powerful system for [generating fake variables](doc/fake_variables.md) that mimic real data. This allows you to develop UI components with realistic data structures before your backend is fully implemented.

### Component Declaration
Create reusable, self-documenting [UI components](doc/component_declaration.md) with typed parameters, making your frontend development more structured and maintainable.

### Showroom

The bundle provides a "showroom" interface which allows you to navigate and display the [components](doc/component_declaration.md) you have created. This makes it easy to test and demonstrate your UI components in isolation.

To access this interface on the URL `/showroom`, add the following route configuration:

```yaml
# config/routes.yaml
showroom:
    resource: "@StaticFakeDesignBundle/Resources/config/routing/showroom.yaml"
```

### Static Version of a Template

The bundle allows you to create static versions of your templates for demonstration purposes. To access these examples at `/static/{path to template}`, add the following route:

```yaml
# config/routes.yaml
static:
    path: /static/{path}
    controller: ErdnaxelaWeb\StaticFakeDesignBundle\Controller\StaticController::viewAction
    requirements:
        path: .*
```

## Usage

There are three ways to use fake generated variables:

### Fake Data Generation

**Twig comment:**
```twig
{# @fake variable_name value_type #}
```

[More information on fake variables](doc/fake_variables.md)

### Component Declaration

**Twig template declared as component:**
```twig
{% component {
    name: 'Component name',
    specifications: 'Optional link to the component specification',
    description: 'Optional component description',
    properties: {
        display_summary: {
            label: 'Display the summary',
            type: 'boolean',
            required: false,
            default: true
        },
        // Other properties...
    },
    parameters: {
        title: {
            label: 'Title',
            type: 'string',
            required: true,
            default: 'Default title'
        },
        // Other parameters...
    }
} %}
```

[More information on component declaration](doc/component_declaration.md)

### Symfony Service

Use the `ErdnaxelaWeb\StaticFakeDesign\Fake\ChainGenerator` service to programmatically generate fake data in your controllers or services:

```php
// Example usage in a controller
public function exampleAction(ChainGenerator $fakeGenerator)
{
    $fakeArticle = $fakeGenerator->generate('content', ['type' => 'article']);
    
    return $this->render('example.html.twig', [
        'article' => $fakeArticle
    ]);
}
```

## Complex Value Objects

The bundle provides support for generating complex value objects commonly used in CMS and web applications:

- [Content](doc/value_types/content.md) - Article, Page, etc.
- [Taxonomy Entry](doc/value_types/taxonomy_entry.md) - Categories, Tags, etc.
- [Pager](doc/value_types/pager.md) - Paginated content listings
- [Block](doc/value_types/block.md) - Hero, CTA, Feature blocks, etc.

These objects are managed through the concept of "definitions". These definitions are **specifications** that allow the bundle to generate thoses complex, structured data.

### Content Definitions

Content definitions specify the structure of content objects:

```yaml
# config/packages/static_fake_design.yaml
erdnaxelaweb.static_fake_design.content_definition:
    article:
        models:
            - 
                name: "First article model"
                image: "article1.jpg"
            - 
                name: "Second article model"
                image: "article2.jpg"
        fields:
            title:
                required: true
                type: string
            body:
                required: true
                type: richtext
            image:
                required: false
                type: image
            related_articles:
                required: false
                type: content
                options:
                    type: "article"
                    max: 3
```

### Taxonomy Entry Definitions

Taxonomy entries follow a similar definition pattern:

```yaml
# config/packages/static_fake_design.yaml
erdnaxelaweb.static_fake_design.taxonomy_entry_definition:
    category:
        fields:
            name:
                required: true
                type: string
            description:
                required: false
                type: text
            icon:
                required: false
                type: string
```

### Pager Definitions

Pagers are configured with content types, filters, and sorting options:

```yaml
# config/packages/static_fake_design.yaml
erdnaxelaweb.static_fake_design.pager_definition:
    articles:
        contentTypes: ["article"]
        filters:
            category:
                type: checkbox
            date:
                type: date_range
        maxPerPage: 10
        headlineCount: 3
        sorts:
            publish_date:
                type: publish_date
```

### Block Definitions

Blocks are configured with views, attributes, and optional models:

```yaml
# config/packages/static_fake_design.yaml
erdnaxelaweb.static_fake_design.block_definition:
    hero:
        views:
            default: "blocks/hero/default.html.twig"
            centered: "blocks/hero/centered.html.twig"
        attributes:
            title:
                required: true
                type: string
            subtitle:
                required: false
                type: string
            background_image:
                required: true
                type: image
```

#### Layout Definitions

Block layouts group blocks together by sections:

```yaml
# config/packages/static_fake_design.yaml
erdnaxelaweb.static_fake_design.block_layout_definition:
    landing_page:
        sections:
            header:
                max: 1
                blocks: ["hero"]
            content:
                blocks: ["text", "image_text", "gallery"]
            sidebar:
                blocks: ["cta", "related_content"]
```

## Documentation

For more detailed documentation on specific features:

- [Fake Variables](doc/fake_variables.md)
- [Component Declaration](doc/component_declaration.md)
- [Content Value Type](doc/value_types/content.md)
- [Taxonomy Entry Value Type](doc/value_types/taxonomy_entry.md)
- [Block Value Type](doc/value_types/block.md)
- [Pager Value Type](doc/value_types/pager.md)

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This bundle is released under the [MIT License](LICENSE).
