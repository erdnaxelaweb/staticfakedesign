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

export class ParametersForm extends Plugin {
  static name = 'parameters_form'

  /**
   * @type {HTMLFormElement}
   */
  form

  constructor() {
    super();

    this.form = document.querySelector('form[name="component_parameters"]')
  }
  /**
   * @param {Showroom} app
   */
  init(app) {
    super.init(app);

    const updatePreview = () => {
      const formData = new FormData(this.form);
      const url = new URL(this.form.action)
      for (const [key, value] of formData) {
        url.searchParams.set(key, value)
      }
      app.setPreviewUrl(url)
    }

    updatePreview()
    this.form.addEventListener('change', (event) => {
      updatePreview()
    })
  }


}
