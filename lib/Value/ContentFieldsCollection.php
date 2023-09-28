<?php
/*
 * ibexadesignbundle.
 *
 * @package   ibexadesignbundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

use Doctrine\Common\Collections\ArrayCollection;

class ContentFieldsCollection extends ArrayCollection
{
    public function __call(string $name, array $arguments)
    {
        $value = $this->get($name);
        if(is_callable($value)){
            return call_user_func_array($value, $arguments);
        }
    }
}
