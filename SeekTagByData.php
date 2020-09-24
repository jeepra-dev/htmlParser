<?php

/**
 * Allow to seach some tag by name or property
 *
 * @author diallo ibrahima
 * @license GNU
 * @version 1.0.1
 */
class SeekTagByData {

    private $tags;

    /**
     * Constructor
     * 
     * @param TagFunc $tags
     */
    public function __construct(TagFunc $tags) {
        $this->tags = $tags;
    }

    /**
     * check if tag contain tag children
     * @TODO writte the logic
     * @param Tag $tag
     */
    private function buildChildren(Tag $tag):void {
        if ($tag->hasChildren()) {
            $nbrChildren = count($tag->getChildren());
            for ($i = 0; $i < $nbrChildren; $i++) {
                $this->buildChildren($tag->getChildren()[$i]);
                if ($tag->getChildren()[$i]->hasProperty()) {
                    var_dump($tag->getChildren()[$i]->getProperty());
                }
            }
        }
    }
    
    public function checkIfmatch(array $data, array $properties): bool {
        $isMatch = 0;
        foreach ($data as $key => $value) {
            foreach ($properties as $property) {
                if ($property->getName() == $key && $property->getValue() == $value) {
                    $isMatch++;
                }
            }
        }

        if (count($data) == $isMatch) {

            return true;
        }

        return false;
    }

    /**
     * Seek tags from data given
     * 
     * @param array $data
     */
    public function search(array $data): array {
        $found = [];
        for ($i = 0; $i < $this->tags->getNbrTag(); $i++) {
            //check if valid attr
            if ($this->tags->getTagCollection()[$i]->hasProperty()) {
                //tag with prpoerty
                $properties = $this->tags->getTagCollection()[$i]->getProperty();
                if ($this->checkIfmatch($data, $properties)) {
                     $found[] = $this->tags->getTagCollection()[$i];
                }
            }
            //@TODO write the logic for children
            //search from childre
            if ($this->tags->getTagCollection()[$i]->hasChildren()) {
                $this->buildChildren($this->tags->getTagCollection()[$i]);
            }
        }
        return $found;
    }

}
