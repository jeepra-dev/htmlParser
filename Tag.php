<?php

require 'Property.php';

class Tag {
    private $html;
    private $property = array();
    private $children = array();
    private $tag;

    /**
     * Constructor
     * 
     * @param string $html
     * @param string $properties
     * @param string $tag
     */
    public function __construct(string $html, string $properties, string $tag) {
        $this->html = $html;
        $this->tag = $tag;
        $extactOnlyPropties = explode(';', $properties);
        $explodePropretie = explode(' ', $extactOnlyPropties[0]);
        $this->setProperty($explodePropretie);
        $this->buildChildren();
    }

    /**
     * Set children tag if exist
     */
    public function buildChildren(): void {
        $callback = function ($match) {
            $this->children[] = new Tag($match[3], $match[1], $this->tag);
        };
        $pattern = "#<$this->tag(.+=\"(.+)?\")*>?(.+)</$this->tag>#";

        preg_replace_callback($pattern, $callback, $this->html);
    }

    /**
     * set property if exist
     * 
     * @param array $properties
     */
    public function setProperty(array $properties): void {
        $callBack = function($match) {
            $this->property[] = new Property($match[1], $match[2]);
        };
        foreach ($properties as $attr) {
            preg_replace_callback('#(.+)="(.+)"#', $callBack, $attr);
        }
    }

    /**
     * Return true if tag has attr
     * 
     * @return array
     */
    public function hasProperty(): bool {
        return !empty($this->property);
    }

    /**
     * Return an html tag
     * 
     * @return string
     */
    public function __toString(): string {
        return $this->html;
    }

    /**
     * has children tag 
     *
     * @return boolean
     */
    public function hasChildren(): bool {
        return !empty($this->children);
    }
    
    /**
     * get children tag(s) 
     *
     * @return array 
     */
    public function getChildren(): array {
        return $this->children;
    }

    /**
     * get properties of tag 
     *
     * @return array 
     */
    public function getProperty(): array {
        return $this->property;
    }

}
