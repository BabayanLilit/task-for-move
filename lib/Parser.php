<?php

namespace App;

/**
 * Class Parser
 * @package App
 */
class Parser
{
    /**
     * @var string
     */
    protected $content;

    /**
     * @var array
     */
    protected $tags = [];

    /**
     * Parser constructor.
     * @param $url string
     */
    public function __construct($url)
    {
        $this->content = $this->getContent($url);
    }

    /**
     * @param $url
     * @return string
     */
    protected function getContent($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }


    /**
     * Запуск парсера
     */
    public function run()
    {
        $this->clearTags();
        $this->prepareContent();
        $this->parseSingleTagsAndJs();
        $this->parseClosedTags();
    }

    /**
     * Парсим закрытые вложенные теги
     */
    public function parseClosedTags()
    {
        $data = $this->content;
        $parser = xml_parser_create();
        xml_set_object($parser, $this);
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_element_handler($parser, "tagOpen", null);
        xml_set_character_data_handler($parser, null);
        xml_parse($parser, $data);
    }

    /**
     * @param $parser
     * @param $tag
     */
    protected function tagOpen($parser, $tag)
    {
        $this->incTagByName($tag);
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param $tagName string
     */
    protected function incTagByName($tagName)
    {
        if (!$tagName) {
            return;
        }

        if (!isset($this->tags[$tagName])) {
            $this->tags[$tagName] = 0;
        }

        $this->tags[$tagName]++;
    }

    /**
     * Очистить теги найденные при последнем запуске
     */
    protected function clearTags()
    {
        $this->tags = [];
    }

    /**
     * Распарсим с помощью регулярок одиночные теги и вставки яваскрипта
     */
    protected function parseSingleTagsAndJs()
    {
        $parser = new HtmlSingleTagAndJsParse($this->content);
        $parser->parse();
        $this->content = $parser->getContent();
        $this->tags = array_merge($this->tags, $parser->getTags());
    }

    /**
     * Удалим коментарии
     */
    protected function prepareContent()
    {
        $this->content = preg_replace('#<!--(.+?)-->#is', '', $this->content);
    }

}