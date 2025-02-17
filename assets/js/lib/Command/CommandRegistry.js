/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

export class CommandRegistry{
  constructor() {
    this.commands = new Map();
  }
  register(name, callback) {
    this.commands.set(name, callback)
  }
  execute(name, target, options) {
    const command = this.commands.get(name);
    if(command) {
      return command.apply(target, options);
    }
  }
}
