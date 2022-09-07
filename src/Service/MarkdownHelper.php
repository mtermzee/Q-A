<?php

namespace App\Service;

class MarkdownHelper
{
    public function parse(string $source): string
    {
        // do something to parse the markdown
        // Autowiring Dependencies into a Servic
        return $cache->get('markdown_' . md5($source), function () use ($source, $parser) {
            return $parser->transformMarkdown($source);
        });
    }
}
