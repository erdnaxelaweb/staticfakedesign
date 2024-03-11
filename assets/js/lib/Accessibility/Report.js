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
import {Result} from "./Result";

export const Report = (results) => {
  const resultsMap = new Map();

  for (const pass of results.passes) {
    const result = {
      id: pass.id,
      description: pass.description,
      help: pass.help,
      helpUrl: pass.helpUrl,
      impact: pass.impact,
      passes: pass.nodes,
      fails: []
    }
    resultsMap.set(pass.id, result)
  }

  for (const incomplete of results.incomplete) {
    if(resultsMap.has(incomplete.id)) {
      const result = resultsMap.get(incomplete.id)
      result.fails = incomplete.nodes
    }else {
      const result = resultsMap.get(incomplete.id) || {
        id: incomplete.id,
        description: incomplete.description,
        help: incomplete.help,
        helpUrl: incomplete.helpUrl,
        impact: incomplete.impact,
        passes: [],
        fails: incomplete.nodes
      }
      resultsMap.set(incomplete.id, result)
    }
  }

  const report = createElFromTemplate(`<div class="accordion accordion-flush" id="accessibility-results"></div>`)
  const resultsIds = [...resultsMap.keys()].sort()
  for (const resultsId of resultsIds) {
    const reportItem = Result(resultsMap.get(resultsId));
    report.appendChild(reportItem)
  }
  return report
}
