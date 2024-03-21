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


const SELECTOR_DATA_EXEC = "[data-showroom-exec]";
const SELECTOR_DATA_PREVIEW_EXEC = "[data-showroom-preview-exec]";

export class Toolbar extends Plugin {
  static name = 'toolbar'

  /**
   * @param {Showroom} app
   */
  init(app) {
    super.init(app);

    this.#registerBreakpoints(app)
    this.#registerReload(app)

    const button = document.querySelectorAll(SELECTOR_DATA_EXEC)
    button.forEach(btn => {
      btn.addEventListener('click', event => {
        event.preventDefault()
        /**
         * @type {HTMLElement}
         */
        const target = event.currentTarget
        app.executeCommand(target.dataset.showroomExec)

      })
    })

    const previewButton = document.querySelectorAll(SELECTOR_DATA_PREVIEW_EXEC)
    previewButton.forEach(btn => {
      btn.addEventListener('click', event => {
        event.preventDefault()
        /**
         * @type {HTMLElement}
         */
        const target = event.currentTarget
        app.getPreview().executeCommand(target.dataset.showroomPreviewExec)
      })
    })
  }

  #registerReload(app) {
    const reloadPreview = () => {
      app.previewIframe.contentWindow.location.reload(true)
    }

    window.addEventListener("keydown", (e)=> {
      e = e || window.event;
      if (e.ctrlKey) {
        var c = e.which || e.keyCode;
        if (c === 82) {
          e.preventDefault();
          e.stopPropagation();
          reloadPreview()
        }
      }
    });

    app.registerCommand('preview-reload', () => {
      reloadPreview()
    })
  }

  #registerBreakpoints(app) {
    const switchBreakpoint = (breakpoint) => {
      app.previewIframe.width = breakpoint.previewSize;
      app.setState('breakpoint', breakpoint.suffix)
    }

    const activeBreakpoint = app.getState('breakpoint')
    for (const breakpoint of breakpoints) {
      app.registerCommand('breakpoint-'+breakpoint.suffix, () => {
        switchBreakpoint(breakpoint)
      })
      if(activeBreakpoint === breakpoint.suffix) {
        switchBreakpoint(breakpoint)
      }
    }
  }
}

