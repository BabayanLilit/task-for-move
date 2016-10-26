<?php

namespace App;

/**
 * Class HtmlSingleTagAndJsParse
 * @package App
 */
class HtmlSingleTagAndJsParse
{
    /**
     * @var string
     */
    protected $content = '';

    /**
     * @var array
     */
    protected  $tags = [];

    const TAGS = [
        'area',
        'base',
        'basefont',
        'bgsound',
        'br',
        'col',
        'command',
        'embed',
        'hr',
        'img',
        'input',
        'isindex',
        'keygen',
        'link',
        'meta',
        'param',
        'source',
        'track',
        'wbr',
        'script',
    ];

    /**
     * HtmlSingleTagAndJsParse constructor.
     * @param $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    public function parse()
    {
        foreach (static::TAGS as $tag) {
            $tagParse = new TagParse($tag, $this->content);

            $tagParse->parse();

            if (!$tagParse->getCount()) {
                continue;
            }

            $this->tags[$tag] = $tagParse->getCount();
            $this->content = $tagParse->getContent();

            unset($tagParse);
        }

    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}