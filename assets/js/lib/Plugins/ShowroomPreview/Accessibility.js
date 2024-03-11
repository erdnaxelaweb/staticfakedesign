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
import axe from "axe-core";

export class Accessibility extends Plugin {
  static name = 'accessibility'
  init(app) {
    super.init(app);

    app.registerCommand('accessibility-tests', (callback) => {
      return axe.run(
        [
          '.component-wrapper'
        ],
        {},
        callback
      )
    })
  }
}
