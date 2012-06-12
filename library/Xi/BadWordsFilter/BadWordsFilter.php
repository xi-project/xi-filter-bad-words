<?php

namespace Xi\BadWordsFilter;

class BadWordsFilter
{
    /**
     * @var array
     */
    private $badWords = array();

    /**
     * @var string
     */
    private $replacement;

    /**
     * @param $badWordsListFile Newline separated list of bad words
     * @param string $replacement Replacement string
     */
    public function __construct($badWordsListFile, $replacement = 'flower')
    {
        $this->replacement = $replacement;
        $wordFile = file($badWordsListFile);
        foreach ($wordFile as $word) {
            if ($word) {
                $word = trim($word, "; \n");
                $word = str_replace("(", "\(", $word);
                $word = str_replace("*", "\w*", $word);
                $this->badWords[] = $word;
            }
        }
    }

    /**
     * @return string
     */
    private function getReplacement()
    {
        return $this->replacement;
    }

    /**
     * @return array
     */
    private function getBadWords()
    {
        return $this->badWords;
    }


    /**
     * Returns a filtered string
     *
     * @param string $unfiltered
     * @return string
     */
    public function filter($unfiltered)
    {
        $filtered = $unfiltered;
        foreach ($this->getBadWords() as $badWord) {
            $regex = "[(^|\s)({$badWord})($|\s)]i";
            preg_match_all($regex, $filtered, $matches);
            $filtered = preg_replace($regex, "$1{$this->getReplacement()}$3", $filtered);
        }
        return $filtered;

    }

}