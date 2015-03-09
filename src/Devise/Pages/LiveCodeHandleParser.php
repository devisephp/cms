<?php namespace Devise\Pages;

use League\CommonMark\Inline\Parser\AbstractInlineParser;
use League\CommonMark\ContextInterface;
use League\CommonMark\InlineParserContext;

class LiveCodeHandleParser extends AbstractInlineParser
{
    public function getCharacters() {
        return array('@');
    }

    public function parse(ContextInterface $context, InlineParserContext $inlineContext) {

var_dump('herer');

        $cursor = $inlineContext->getCursor();

        // Save the cursor state in case we need to rewind and bail
        $previousState = $cursor->saveState();

        // Advance past the @ symbol to keep parsing simpler
        $cursor->advance();

        // Parse the handle
        $handle = $cursor->match('/live-code\([\"|\'](.*)\|(.*)[\"|\']\)/');

        if (empty($handle)) {
            // Regex failed to match; this isn't a valid Twitter handle
            $cursor->restoreState($previousState);

            return false;
        }
dd($inlineContext->getInlines());
        $inlineContext->getInlines()->add($handle);

        return true;
    }
}