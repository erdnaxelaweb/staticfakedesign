/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

const STATE_IDENTIFIER_PREFIX = 'showroom-'
export class StateManager {
  constructor() {
  }

  #getStateId(id) {
    return `${STATE_IDENTIFIER_PREFIX}${id}`
  }
  /**
   * @param [string] id
   * @returns {*}
   */
  getState(id) {
    return JSON.parse(localStorage.getItem(this.#getStateId(id))) || null
  }

  /**
   * @param {string} id
   * @param {*} value
   */
  setState(id, value) {
    localStorage.setItem(this.#getStateId(id), JSON.stringify(value));
  }
}
