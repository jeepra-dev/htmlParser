<?php

require 'SeekTag.php';
require 'Tag.php';

class TagFunc {

    private $tagOpen;
    private $tagClose;
    private $tagOpenWithSpace;
    private $nbrTag = 0;
    private $floor = 0;
    private $html = [];
    private $tag;
    private $attrHtml = [];
    private $attrHtmlAddr = 0;
    private $splFileObject;
    private $tagCollection = [];
    private $attrGet = true;

    /**
     * Constructor.
     * 
     * @param string $filename
     * @param string $tag
     */
    public function __construct(string $fileName, string $tag) {
        $fileNameExplode = explode('.', $fileName);
        $extensionOfFileName = end($fileNameExplode);
        if ($extensionOfFileName != 'html' && $extensionOfFileName != 'xml') {
            throw new LogicException('L\'extension de votre fichier n\'est pas supporté');
        }

        $this->tag = $tag;
        $this->splFileObject = new SplFileObject($fileName);
        $this->tagOpen = new SeekTag(self::getTagFormatOpenFromName($tag));
        $this->tagOpenWithSpace = new SeekTag(self::getTagFormatOpenFromName($tag, false));
        $this->tagClose = new SeekTag(self::getTagFormatCloseFromName($tag));
        $this->readFile();
    }

    /**
     * Formated open tag
     * 
     * @param string $tag
     * @param string $addedSpace
     * @return string
     */
    public static function getTagFormatOpenFromName(string $tag, bool $addedSpace = true): string {
        $add = ($addedSpace) ? '>' : ' ';
        return '<' . $tag . $add;
    }

    /**
     * Formated close tag
     * 
     * @param string $tag
     * @return type
     */
    public static function getTagFormatCloseFromName(string $tag): string {
        return '</' . $tag . '>';
    }

    /**
     * Create a collection of tags
     */
    public function setTagCollection(): void {
        foreach ($this->html as $key => $tagChildren) {
            $attrs = '';
            if (isset($this->attrHtml[$key])) {
                $attrs = $this->attrHtml[$key];
            }
            $this->tagCollection[] = new Tag($tagChildren, $attrs, $this->tag);
        }
    }

    /*
     * Read a file
     */
    public function readFile(): void {
        while (($letter = $this->splFileObject->fgetc()) !== false) {
            //opened tag like <tag> OR like <tag 
            if ($checkTagOpen = $this->tagOpen->check($letter) || $this->tagOpenWithSpace->check($letter)) {
                // var_dump($this->tagOpen);
                $this->floor++;
                $this->fillTag(true);
            } elseif ($this->tagClose->check($letter)) {
                //closed tag
                $this->floor--;
                $this->fillTag(false);
            }
            //add char on tab
            $this->addLetter($letter);
        }

        //get attr for each tag
        $this->setTagCollection();
    }

    /**
     * Check if file has been open
     * 
     * @return boolean
     */
    public function isOpen(): bool {
        return $this->splFileObject->valid();
    }

    /**
     * fill html array for each tag
     * 
     * @param bool $checkTagOpen
     */
    private function fillTag(bool $checkTagOpen = false): void {
        switch ($this->floor) {
            case '0':
                $seekTag = self::getTagFormatCloseFromName($this->tag);
                $closeTag = substr($seekTag, strlen($seekTag) - 1, 1);
                $this->html[$this->nbrTag] = $this->html[$this->nbrTag] . $closeTag;
                $this->nbrTag++;
                break;
            case '1':
                $seekTag = self::getTagFormatOpenFromName($this->tag, $checkTagOpen);
                if (!isset($this->html[$this->nbrTag])) {
                    $openTag = substr($seekTag, 0, strlen($seekTag) - 1);
                    $this->html[$this->nbrTag] = $openTag;
                }
                break;
        }
    }

    /**
     * add letter by letter for finded tag
     * 
     * @param string $letter
     */
    private function addLetter(string $letter): void {
        if ($this->floor >= 1) {
            if (!isset($this->html[$this->nbrTag])) {
                $this->html[$this->nbrTag] = '';
            }
            $this->attrHtmlAddr = $this->nbrTag;
            $this->html[$this->nbrTag] .= $letter;
            //start to get attr
            if ($this->tagOpenWithSpace->hasAttribute()) {
                $this->addAttrChar($letter);
            }
        }
    }

    /**
     * Add character when loop find char which find in attr
     * 
     * @param string $letter
     */
    private function addAttrChar(string $letter): void {
        if ($letter == '>') {
            $this->tagOpenWithSpace->setAttribute(false);
            $this->attrHtml[$this->attrHtmlAddr] = $this->attrHtml[$this->attrHtmlAddr] . ';';
        } else {
            if (!isset($this->attrHtml[$this->attrHtmlAddr])) {
                $this->attrHtml[$this->attrHtmlAddr] = '';
            }
            $this->attrHtml[$this->attrHtmlAddr] = $this->attrHtml[$this->attrHtmlAddr] . $letter;
        }
    }

    /**
     * Return html content
     * 
     * @return type
     */
    public function getHtml(): string {
        return $this->html;
    }

    /**
     * Return html content of attr
     * 
     * @return type
     */
    public function getAttrHtml(): string {
        return $this->attrHtml;
    }

    /**
     * Nbr of tag found
     * 
     * @return int
     */
    public function getNbrTag(): int {
        return $this->nbrTag;
    }

    /**
     * 
     * @return array
     */
    public function getTagCollection(): array {
        return $this->tagCollection;
    }

}
