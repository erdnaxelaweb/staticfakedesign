/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

import {ShowroomPreview} from "./lib/ShowroomPreview";
import {Accessibility} from "./lib/Plugins/ShowroomPreview/Accessibility";
import {Highlight} from "./lib/Plugins/ShowroomPreview/Highlight";
import {Zoom} from "./lib/Plugins/ShowroomPreview/Zoom";

((global, document, body) => {
  const showroomPreview = global.showroomPreview = new ShowroomPreview(document.body)
  showroomPreview.registerPlugin(Accessibility.name, new Accessibility())
  showroomPreview.registerPlugin(Highlight.name, new Highlight())
  showroomPreview.registerPlugin(Zoom.name, new Zoom(body))
})(window, document, document.body)

