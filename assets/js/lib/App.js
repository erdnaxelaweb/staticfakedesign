/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */


import {CommandRegistry} from "./Command/CommandRegistry";
import {StateManager} from "./StateManager";

export class App {

  constructor() {
    this.commandRegistry = new CommandRegistry();
    this.plugins = new Map()
    this.stateManager = new StateManager()
  }

  /**
   * @param {string} name
   * @param {Plugin} plugin
   */
  registerPlugin(name, plugin) {
    this.plugins.set(name, plugin)
    plugin.init(this)
  }

  /**
   * @param {string} name
   * @param {function} callback
   */
  registerCommand(name, callback) {
    this.commandRegistry.register(name, callback)
  }

  /**
   * @param {string} name
   * @param {array|null} options
   * @returns {*}
   */
  executeCommand(name, options) {
    return this.commandRegistry.execute(name, this, options ?? []);
  }

  /**
   * @param [string] id
   * @returns {*}
   */
  getState(id) {
    return this.stateManager.getState(id)
  }

  /**
   * @param {string} id
   * @param {*} value
   */
  setState(id, value) {
    this.stateManager.setState(id, value)
  }

}
