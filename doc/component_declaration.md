# Component declaration

By using the following syntax, you can declare a template as a component.

You can then use the "showroom" to view each declared components.

```twig
{% component {
    name: 'Component name',
    specifications: 'Optionnal link to the component specification',
    description: 'Optionnal component description',
    properties: [],
    parameters: []
} %}
```

## Component parameters/properties

It's possible to add parameters/properties to a component.

When displayed in the "showroom", you will be able to see the differents parameters for the component and even interact with them (depending on the parameter type).
A value (random or default value) will also be generated for each required parameters and each properties (required or not).

There is two way to declare a component parameter/property :
```twig
    properties: {
        <identifier>: '<value type>'
        title: 'sentence'
    },
    parameters: {
        <identifier>: '<value type>'
        title: 'sentence'
    }
```

```twig
    properties: {
        <identifier>: {
            label: 'Optionnal parameter label',
            type: '<value type>',
            required: <true|false>,
            default: '<default value>'
        }
        
        display_summary: {
            label: 'Display the summary',
            type: 'boolean',
            required: 'false',
            default: true
        },
    },
    parameters: {
        <identifier>: {
            label: 'Optionnal parameter label',
            type: '<value type>',
            required: <true|false>,
            default: '<default value>'
        }
        
        ...
    }
```

When a parameter has a default value :
- the type become optionnal and will be determined by the default value type.
- the parameter is by default not required

The available value types can be found [here](fake_variables.md)
