<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Templating\Twig;

class CommentReplacer
{
    public function replaceInString(string $string): string
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
                        !empty($comment['array_size']) ? $comment['array_size'] : 'null',
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

    /**
     * @return array{string: string, fake_name: string, fake_type: string, fake_parameters: string, is_array: bool,
     *                       array_size: string|null}[]
     */
    protected function matchComments(string $string): array
    {
        $matches = [];
        preg_match_all(
            '/{# @fake ([^\s]+) (\w+)(?:\(([^)]+)\))?(?:\[(\d*)\])? #}/',
            $string,
            $matches,
            PREG_SET_ORDER
        );
        $comments = [];
        foreach ($matches as $match) {
            $fakeParameters = $match[3] ?? null;
            if ($fakeParameters === null || !str_starts_with($fakeParameters, "{")) {
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
