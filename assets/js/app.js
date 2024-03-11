/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

import {Showroom} from "./lib/Showroom";
import {Toolbar} from "./lib/Plugins/Showroom/Toolbar";
import {Accessibility} from "./lib/Plugins/Showroom/Accessibility";

// Loads the prismjs package
require('prismjs');
// Loads the plugin to normalize whitespace
require('prismjs/plugins/normalize-whitespace/prism-normalize-whitespace');
// Constant loading the dependencies
const getLoader = require('prismjs/dependencies');
// Constant loading the components
const components = require('prismjs/components');

// Constants for the components to load :
const componentsToLoad = ['twig', 'css', 'css-extras', 'scss', 'php', 'php-extras', 'json', 'yml', 'html'];
const loadedComponents = ['clike', 'markup-templating', 'javascript'];

const loader = getLoader(components, componentsToLoad, loadedComponents);
loader.load(id => {
  require(`prismjs/components/prism-${id}.min.js`);
});

((global, doc) => {
  const showroom = global.showroom = new Showroom(doc)

  showroom.registerPlugin(Toolbar.name, new Toolbar())
  showroom.registerPlugin(Accessibility.name, new Accessibility())

  const pathArray = path.split('/');
  do {
    const ps = pathArray.join('/');
    /**
     * @type {HTMLElement[]}
     */
    const els = doc.querySelectorAll(`[data-path="${ps}"]`)
    for (const el of els) {
      el.classList.add('menu-open')
      el.querySelector('a.nav-link').classList.add('active')
    }
    pathArray.pop()
  }while (pathArray.length > 0)
})(window, document)
