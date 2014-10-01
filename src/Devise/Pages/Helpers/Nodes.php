<?php namespace Devise\Pages\Helpers;

use Devise\Pages\Helpers\Strings;
use Devise\Pages\Parsers\AttributeParser;

class Nodes {

    public static function replaceStyle($node, $replaceWith, $params)
    {
        if($node->hasAttribute('style')){
            $currentStyles = $node->getAttribute('style');
            $stylesArr = explode(';', $currentStyles);
            foreach ($stylesArr as $key => $value) {
                if(strpos($value, $params[1]) !== false){
                    $stylesArr[ $key ] = $params[1] . ':' . $replaceWith . ' ';
                }
            }
            $node->setAttribute('style', implode(';', $stylesArr));
        } else {
            $node->setAttribute('style', $params[1] . ':' . $replaceWith . ' ');
        }
    }

    public static function getStyleValue($node, $params)
    {
        $val = '';
        if($node->hasAttribute('style')){
            $currentStyles = $node->getAttribute('style');
            $stylesArr = explode(';', $currentStyles);
            foreach ($stylesArr as $key => $value) {
                if(strpos($value, $params[1]) !== false){
                    $styleArr = explode(":", $value);
                    $val = $styleArr[1];
                    break;
                }
            }
        }
        
        return $val;
    }

    public static function replaceData($node, $fieldName, $params)
    {
        if($node->hasAttribute($params[0])){
            $currentData = $node->getAttribute($params[0]);
            $obj = (array) json_decode($currentData);
            $obj[$params[1]] = $fieldName;
            $node->setAttribute($params[0], str_replace('"', "'", json_encode($obj)));
        } else {
            $node->setAttribute($params[0], '{\'' . $params[1] . '\':\'' . $fieldName . ' \'}');
        }
    }

    public static function getDataValue($node, $params)
    {
        if($node->hasAttribute($params[0])){
            $currentData = $node->getAttribute($params[0]);
            $obj = (array) json_decode($currentData);
            return $obj[$params[1]];
        }
        
        return '';
    }

    public static function getInnerHtml( $node ) {
        $innerHTML= '';
        $children = $node->childNodes;
        foreach ($children as $child) {
            $innerHTML .= $child->ownerDocument->saveXML( $child );
        }
        return $innerHTML;
    }

    public static function addClass($node, $className)
    {
        if($node->hasAttribute('class'))
        {
            $classes = $node->getAttribute('class');
            $node->setAttribute('class', $classes . ' ' . $className);

        } else {
            $node->setAttribute('class', $className);
        }
    }

    public static function replaceWithTmpYield($node, $dom, $sectionName)
    {
        $yield = $dom->createElement('yield');
        $yield->setAttribute('data-name', $sectionName);
        $node->parentNode->replaceChild($yield, $node);
    }

    public static function replaceWithBladeYield($node, $dom, $sectionName)
    {
        $node->parentNode->replaceChild($dom->createTextNode("@yield('$sectionName')"), $node);
    }

    public static function replaceWithBladeInclude($node, $dom, $sectionName)
    {
        $node->parentNode->replaceChild($dom->createTextNode("@include('$sectionName')"), $node);
    }

    public static function findParentTemplateName($node)
    {
        $parent = ($node->tagName != 'body') ? $node->parentNode : $node;
        if($parent->hasAttribute('data-devise')){
            $attr = $parent->getAttribute('data-devise');
            if(strpos($attr, 'section') === 0 || strpos($attr, 'layout') === 0){
                $AttributeParser = new AttributeParser();
                $settings = $AttributeParser->parse($attr);
                return ($parent->tagName == 'body') ? $settings['name'] : $settings['path'];
            } else {
                return self::findParentTemplateName($parent);
            }
        } else {
            return self::findParentTemplateName($parent);
        }
    }

    public static function getOpenTagHtml($node)
    {
        $html = "&lt;" . $node->tagName;
        foreach ($node->attributes as $name => $attrNode) {
            $html .= ' ' . $name . '="' . $attrNode->value .'"';
        }
        return $html . "&gt;";
    }
}