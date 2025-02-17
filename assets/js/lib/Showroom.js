/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */



import {App} from "./App";

export class Showroom extends App {

  /**
   *
   * @param {HTMLElement} container
   */
  constructor(container) {
    super();

    /**
     * @type {HTMLIFrameElement}
     */
    this.previewIframe = container.querySelector('#preview-canvas iframe')
  }

  /**
   * @param {URL} url
   */
  setPreviewUrl(url) {
    this.previewIframe.src = url;
  }

  /**
   *
   * @returns {ShowroomPreview}
   */
  getPreview() {
    return this.previewIframe.contentWindow.showroomPreview
  }
}

