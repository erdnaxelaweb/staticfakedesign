/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

/**
 * @param {string} template
 * @returns {ChildNode}
 */
export const createElFromTemplate = (template) => {
  const tmp = document.createElement('div');
  tmp.innerHTML = template;
  return tmp.children.item(0);
}
