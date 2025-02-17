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
import {Node} from "./Node";

export const ResultDetail = (result) => {
  return createElFromTemplate(`
    <div>
        <p>${result.description}</p>
        <a href="${result.helpUrl}" target="_blank">More info...</a>
        <ol>
            ${result.fails.map((node) => Node(node).outerHTML)}
        </ol>
    </div>
  `)
}

export const Result = (result) => {
  const detail = ResultDetail(result)
  const total = result.passes.length + result.fails.length
  const progress = Math.floor(result.passes.length / total * 100)
  const progressColor = progress === 100 ? 'bg-success' : 'bg-danger'
  return createElFromTemplate(`
<div class="accordion-item">
  <div class="accordion-header" id="accessibility-result-${result.id}">
    <button class="accordion-button collapsed ${progressColor}-subtle" type="button" data-bs-toggle="collapse" data-bs-target="#accessibility-result-${result.id}-detail" aria-expanded="false" aria-controls="accessibility-result-${result.id}-detail">
      <span class="w-75 ps-2 pe-2">${result.help}</span>
      <span class="w-25 ps-2 pe-2">
        <span class="progress">
            <span class="progress-bar ${progressColor}" role="progressbar" style="width: ${progress}%" aria-valuenow="${progress}" aria-valuemin="0" aria-valuemax="100">${progress}%</span>
        </span>
      </span>
    </button>
  </div>
  <div id="accessibility-result-${result.id}-detail" class="accordion-collapse collapse" aria-labelledby="accessibility-result-${result.id}" data-bs-parent="#accessibility-results">
    <div class="accordion-body">
        ${detail.outerHTML}
    </div>
  </div>
</div>`)
}

