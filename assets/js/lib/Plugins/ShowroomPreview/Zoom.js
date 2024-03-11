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

export class Zoom extends Plugin {
  static name= 'Zoom'
  currentZoom = 1

  constructor(container) {
    super();
    this.container = container
  }

  init(app) {
    super.init(app);

    app.registerCommand('zoom-in', () => {
      this.changeZoom(this.currentZoom * 1.25)
    })
    app.registerCommand('zoom-out', () => {
      this.changeZoom(this.currentZoom / 1.25)
    })
    app.registerCommand('zoom-reset', () => {
      this.changeZoom(1);
    })
  }

  changeZoom(zoom) {
    this.currentZoom = zoom
    this.container.style.width = 100 / zoom + '%';
    this.container.style.height = 100 / zoom + '%';
    this.container.style.transform = "scale(" + zoom + ")";
    this.container.style.transformOrigin = "left top 0px";
  }
}
