<?php

namespace App;

/**
 * Class TagParse
 * @package App
 */
class TagParse
{
    /**
     * @var string
     */
    protected $tagName = '';

    /**
     * @var int
     */
    protected $count = 0;

    /**
     * @var string
     */
    protected $content = '';

    /**
     * TagParse constructor.
     * @param $tagName
     * @param $content
     */
    public function __construct($tagName, $content)
    {
        $this->tagName = $tagName;
        $this->content = $content;
    }

    /**
     * parse
     */
    public function parse()
    {
        $this->content = preg_replace_callback(
            '#<'. $this->tagName . '(.+?)(></' . $this->tagName . '\s*>|>)#is',
            function ($matches) {
                $this->incCount();
                return '';
            },
            $this->content
        );
    }

    /**
     * inc count
     */
    protected function incCount()
    {
        $this->count++;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}