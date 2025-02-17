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
import {Report} from "../../Accessibility/Report";

export class Accessibility extends Plugin {
  static name = 'accessibility'

  /**
   * @param {Showroom} app
   */
  init(app) {
    super.init(app);

    const initCheckboxes = (container) => {
      const highlightToggle = container.querySelectorAll('[type="checkbox"].highlight-toggle')
      for (const highlightToggleElement of highlightToggle) {
        highlightToggleElement.addEventListener('click', (ev) => {
          app.getPreview().executeCommand('toggle-highlight-el', [ev.currentTarget.value])
        })
      }
    }
    initCheckboxes(document)

    const accessibilityResultsContainer = document.querySelector('.accessibility-results')
    app.previewIframe.onload = (evt) => {
      app.getPreview().executeCommand('accessibility-tests')
        .then((results) => {
          accessibilityResultsContainer.innerHTML = '';
          accessibilityResultsContainer.append(Report(results))
          initCheckboxes(accessibilityResultsContainer)
        })
    }
  }
}
