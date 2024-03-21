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
  /**
   * {number}
   */
  currentZoom

  constructor(container) {
    super();
    this.container = container
  }

  init(app) {
    super.init(app);

    const getCurrentZoom = () => {
      return app.getState('zoom') || 1
    }
    const setCurrentZoom = (zoom) => {
      app.setState('zoom', zoom)
    }

    const changeZoom = (zoom) => {
      setCurrentZoom(zoom)
      this.container.style.width = 100 / zoom + '%';
      this.container.style.height = 100 / zoom + '%';
      this.container.style.transform = "scale(" + zoom + ")";
      this.container.style.transformOrigin = "left top 0px";
    }

    changeZoom(getCurrentZoom())
    app.registerCommand('zoom-in', () => {
      changeZoom(getCurrentZoom() * 1.25)
    })
    app.registerCommand('zoom-out', () => {
      changeZoom(getCurrentZoom() / 1.25)
    })
    app.registerCommand('zoom-reset', () => {
      changeZoom(1);
    })
  }



}
