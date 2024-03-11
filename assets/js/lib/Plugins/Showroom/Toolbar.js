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

    for (const breakpoint of breakpoints) {
      app.registerCommand('breakpoint-'+breakpoint.suffix, () => {
        app.previewIframe.width = breakpoint.previewSize;
      })
    }

    app.registerCommand('preview-reload', () => {
      app.previewIframe.src = app.previewIframe.src;
    })

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
}

