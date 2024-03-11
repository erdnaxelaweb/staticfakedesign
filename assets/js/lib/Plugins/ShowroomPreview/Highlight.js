/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

import {Plugin} from "../../Plugin";

export class Highlight extends Plugin {
  static name = 'highlight'
  init(app) {
    super.init(app);

    /**
     * @type {HTMLStyleElement}
     */
    const style = document.querySelector('#preview-style');
    const highlighted = new Map();
    app.registerCommand('toggle-highlight-el', (selector) => {
      let position = highlighted.get(selector)
      if(position === undefined) {
        position = style.sheet.insertRule(
          `${selector} {
        outline: 2px dashed #FF4400;
        outline-offset: 2px;
        box-shadow: 0 0 0 6px rgba(255,255,255,0.6);
      }`
        );
        highlighted.set(selector, position)
      }else {
        style.sheet.deleteRule(position);
        highlighted.delete(selector)
      }
    })
  }
}
