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

export class App {

  constructor() {
    this.commandRegistry = new CommandRegistry();
    this.plugins = new Map()
  }

  registerPlugin(name, plugin) {
    this.plugins.set(name, plugin)
    plugin.init(this)
  }

  registerCommand(name, callback) {
    this.commandRegistry.register(name, callback)
  }
  executeCommand(name, options) {
    return this.commandRegistry.execute(name, this, options ?? []);
  }
}
