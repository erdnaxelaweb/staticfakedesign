<?php
/*
 * DesignBundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2018 Novactive
 * @license   https://github.com/Novactive/NovaHtmlIntegrationBundle/blob/master/LICENSE
 */

declare(strict_types=1);

namespace ErdnaxelaWeb\StaticFakeDesign\Templating\Twig;

class CommentReplacer
{
    public function replaceInString(string $string)
    {
        $comments = $this->matchComments($string);
        foreach ($comments as $comment) {
            if ($comment['is_array']) {
                $string = str_replace(
                    $comment['string'],
                    sprintf(
                        '{%% set %s = %s is defined ? %s : generateFakeArray(%s, "%s", %s) %%}',
                        $comment['fake_name'],
                        $comment['fake_name'],
                        $comment['fake_name'],
                        ! empty($comment['array_size']) ? $comment['array_size'] : 'null',
                        addslashes($comment['fake_type']),
                        $comment['fake_parameters']
                    ),
                    $string
                );
            } else {
                $string = str_replace(
                    $comment['string'],
                    sprintf(
                        '{%% set %s = %s is defined ? %s : generateFake("%s", %s) %%}',
                        $comment['fake_name'],
                        $comment['fake_name'],
                        $comment['fake_name'],
                        addslashes($comment['fake_type']),
                        $comment['fake_parameters']
                    ),
                    $string
                );
            }
        }
        return $string;
    }

    protected function matchComments(string $string)
    {
        $matches = [];
        preg_match_all('/{# @fake ([^\s]+) (\w+)(?:\(([^)]+)\))?(?:\[(\d*)\])? #}/', $string, $matches, PREG_SET_ORDER);
        $comments = [];
        foreach ($matches as $match) {
            $fakeParameters = $match[3] ?? null;
            if ($fakeParameters === null || strpos($fakeParameters, "{") !== 0) {
                $fakeParameters = sprintf('[%s]', $fakeParameters);
            }
            $comments[] = [
                "string" => $match[0],
                "fake_name" => $match[1],
                "fake_type" => $match[2],
                "fake_parameters" => $fakeParameters,
                "is_array" => isset($match[4]),
                "array_size" => $match[4] ?? null,
            ];
        }
        return $comments;
    }
}
