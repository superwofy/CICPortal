<?php

namespace fivefilters\Readability\Nodes;

use fivefilters\Readability\Nodes\DOM\DOMDocument;
use fivefilters\Readability\Nodes\DOM\DOMElement;
use fivefilters\Readability\Nodes\DOM\DOMNode;
use fivefilters\Readability\Nodes\DOM\DOMNodeList;

/**
 * Class NodeUtility.
 */
class NodeUtility
{
    /**
     * Collection of regexps to check the node usability.
     *
     * @var array
     */
    public static $regexps = [
        'unlikelyCandidates' => '/-ad-|ai2html|banner|breadcrumbs|combx|comment|community|cover-wrap|disqus|extra|footer|gdpr|header|legends|menu|related|remark|replies|rss|shoutbox|sidebar|skyscraper|social|sponsor|supplemental|ad-break|agegate|pagination|pager|popup|yom-remote/i',
        'okMaybeItsACandidate' => '/and|article|body|column|content|main|shadow/i',
        'extraneous' => '/print|archive|comment|discuss|e[\-]?mail|share|reply|all|login|sign|single|utility/i',
        'byline' => '/byline|author|dateline|writtenby|p-author/i',
        'replaceFonts' => '/<(\/?)font[^>]*>/i',
        'normalize' => '/\s{2,}/',
        'videos' => '/\/\/(www\.)?((dailymotion|youtube|youtube-nocookie|player\.vimeo|v\.qq)\.com|(archive|upload\.wikimedia)\.org|player\.twitch\.tv)/i',
        'shareElements' => '/(\b|_)(share|sharedaddy)(\b|_)/i',
        'nextLink' => '/(next|weiter|continue|>([^\|]|$)|»([^\|]|$))/i',
        'prevLink' => '/(prev|earl|old|new|<|«)/i',
        'tokenize' => '/\W+/',
        'whitespace' => '/^\s*$/',
        'hasContent' => '/\S$/',
        'positive' => '/article|body|content|entry|hentry|h-entry|main|page|pagination|post|text|blog|story/i',
        'negative' => '/-ad-|hidden|^hid$| hid$| hid |^hid |banner|combx|comment|com-|contact|foot|footer|footnote|gdpr|masthead|media|meta|outbrain|promo|related|scroll|share|shoutbox|sidebar|skyscraper|sponsor|shopping|tags|tool|widget/i',
        // \x{00A0} is the unicode version of &nbsp;
        'onlyWhitespace' => '/\x{00A0}|\s+/u',
        'hashUrl' => '/^#.+/',
        'srcsetUrl' => '/(\S+)(\s+[\d.]+[xw])?(\s*(?:,|$))/',
        'b64DataUrl' => '/^data:\s*([^\s;,]+)\s*;\s*base64\s*,/i',
        // See: https://schema.org/Article
        'jsonLdArticleTypes' => '/^Article|AdvertiserContentArticle|NewsArticle|AnalysisNewsArticle|AskPublicNewsArticle|BackgroundNewsArticle|OpinionNewsArticle|ReportageNewsArticle|ReviewNewsArticle|Report|SatiricalArticle|ScholarlyArticle|MedicalScholarlyArticle|SocialMediaPosting|BlogPosting|LiveBlogPosting|DiscussionForumPosting|TechArticle|APIReference$/'
     
    ];

    /**
     * Finds the next node, starting from the given node, and ignoring
     * whitespace in between. If the given node is an element, the same node is
     * returned.
     * 
     * Imported from the Element class on league\html-to-markdown.
     *
     * @param $node
     *
     * @return DOMNode
     */
    public static function nextNode($node)
    {
        $next = $node;
        while ($next
            && $next->nodeType !== XML_ELEMENT_NODE
            && $next->isWhitespace()) {
            $next = $next->nextSibling;
        }

        return $next;
    }

    /**
     * Changes the node tag name. Since tagName on DOMElement is a read only value, this must be done creating a new
     * element with the new tag name and importing it to the main DOMDocument.
     *
     * @param DOMNode $node
     * @param string $value
     * @param bool $importAttributes
     *
     * @return DOMNode
     */
    public static function setNodeTag($node, $value, $importAttributes = true)
    {
        $new = new DOMDocument('1.0', 'utf-8');
        $new->appendChild($new->createElement($value));

        $children = $node->childNodes;
        /** @var $children \DOMNodeList $i */
        for ($i = 0; $i < $children->length; $i++) {
            $import = $new->importNode($children->item($i), true);
            $new->firstChild->appendChild($import);
        }

        if ($importAttributes) {
            // Import attributes from the original node.
            foreach ($node->attributes as $attribute) {
                $new->firstChild->setAttribute($attribute->nodeName, $attribute->nodeValue);
            }
        }

        // The import must be done on the firstChild of $new, since $new is a DOMDocument and not a DOMElement.
        $import = $node->ownerDocument->importNode($new->firstChild, true);
        $node->parentNode->replaceChild($import, $node);

        return $import;
    }

    /**
     * Removes the current node and returns the next node to be parsed (child, sibling or parent).
     *
     * @param DOMNode $node
     *
     * @return DOMNode
     */
    public static function removeAndGetNext($node)
    {
        $nextNode = self::getNextNode($node, true);
        $node->parentNode->removeChild($node);

        return $nextNode;
    }

    /**
     * Remove the selected node.
     *
     * @param $node DOMElement
     *
     * @return void
     **/
    public static function removeNode($node)
    {
        $parent = $node->parentNode;
        if ($parent) {
            $parent->removeChild($node);
        }
    }

    /**
     * Returns the next node. First checks for children (if the flag allows it), then for siblings, and finally
     * for parents.
     *
     * @param DOMNode $originalNode
     * @param bool $ignoreSelfAndKids
     *
     * @return DOMNode
     */
    public static function getNextNode($originalNode, $ignoreSelfAndKids = false)
    {
        /*
         * Traverse the DOM from node to node, starting at the node passed in.
         * Pass true for the second parameter to indicate this node itself
         * (and its kids) are going away, and we want the next node over.
         *
         * Calling this in a loop will traverse the DOM depth-first.
         */

        // First check for kids if those aren't being ignored
        if (!$ignoreSelfAndKids && $originalNode->firstChild) {
            return $originalNode->firstChild;
        }

        // Then for siblings...
        if ($originalNode->nextSibling) {
            return $originalNode->nextSibling;
        }

        // And finally, move up the parent chain *and* find a sibling
        // (because this is depth-first traversal, we will have already
        // seen the parent nodes themselves).
        do {
            $originalNode = $originalNode->parentNode;
        } while ($originalNode && !$originalNode->nextSibling);

        return ($originalNode) ? $originalNode->nextSibling : $originalNode;
    }

    /**
     * Remove all empty DOMNodes from DOMNodeLists.
     *
     * @param \DOMNodeList $list
     *
     * @return DOMNodeList
     */
    public static function filterTextNodes(\DOMNodeList $list)
    {
        $newList = new DOMNodeList();
        foreach ($list as $node) {
            if ($node->nodeType !== XML_TEXT_NODE || mb_strlen(trim($node->nodeValue))) {
                $newList->add($node);
            }
        }

        return $newList;
    }
}
