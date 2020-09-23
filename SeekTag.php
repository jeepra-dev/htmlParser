<?php

class SeekTag {

    private $name;
    private $position = 0;
    private $matchedLetter = 0;
    private $nameLenght = 0;
    private $lastMatchedLetter = 0;
    private $attrContain = false;

    /**
     * constructor
     * @param string $name
     */
    function __construct(string $name) {
        $this->name = $name;
        $this->nameLenght = strlen($name);
    }

    /**
     * Checker of letter , return true when matched tag will be find
     * 
     * @param string $letter
     * @return boolean
     */
    public function check(string $letter): bool {
        //first Letter match
        if (isset($this->name[$this->position])) {
            if ($this->name[$this->position] == $letter) {
                //Letter matched
                $this->matchedLetter++;
                // next letter
                $this->position++;
            } else {
                $this->reset();
            }

            return $this->isMatched();
        }

        return false;
    }

    /**
     * When one tag is find, it return true
     * 
     * @return boolean
     */
    private function isMatched(): bool {
        if ($this->matchedLetter == $this->nameLenght) {
            $this->reset();
            if (!strpos('>', $this->name)) {
                $this->attrContain = true;
            }
            
            return true;
        }
        
        return false;
    }

    /**
     * When one tag is find, it initialize a seek for the new tag 
     */
    private function reset(): void {
        $this->position = 0;
        $this->lastMatchedLetter = $this->matchedLetter;
        $this->matchedLetter = 0;
    }

    /**
     * Check if tag has attr
     * 
     * @return boolean
     */
    public function hasAttribute(): bool {
        return $this->attrContain;
    }

    /**
     * Check if tag has attr
     * 
     * @return boolean
     */
    public function setAttribute(bool $bool): void {
        $this->attrContain = $bool;
    }

}
