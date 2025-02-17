/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

import {createElFromTemplate} from "../Utils";

export const ImpactValue = {
  MINOR: 'minor',
  MODERATE: 'moderate',
  SERIOUS: 'serious',
  CRITICAL: 'critical'
}

const formatSeverityText = (severity) => {
  return severity.charAt(0).toUpperCase().concat(severity.slice(1));
};

export const Rule = (rule) => {
  let badgeType = null;
  switch (rule.impact) {
    case ImpactValue.CRITICAL:
      badgeType = 'bg-danger';
      break;
    case ImpactValue.SERIOUS:
      badgeType = 'bg-warning text-dark';
      break;
    case ImpactValue.MODERATE:
      badgeType = 'bg-secondary';
      break;
    case ImpactValue.MINOR:
      badgeType = 'bg-light text-dark';
      break;
    default:
      break;
  }
  return createElFromTemplate(`
<p>
    <span class="badge rounded-pill ${badgeType}">${formatSeverityText(rule.impact)}</span> ${rule.message}
</p>
`)
}

export const Node = (node) => {
  const {any, all, none} = node;
  const rules = [...any, ...all, ...none];

  return createElFromTemplate(`
<li>
  <span class="border-bottom d-flex">
    <strong class="me-auto">${node.target[0]}</strong>
    <input class="highlight-toggle" type="checkbox" value='${node.target[0]}'>
  </span>
  <div>
    ${rules.map((rule, index) => Rule(rule).outerHTML)}
  </div>
</li>
`)

}
