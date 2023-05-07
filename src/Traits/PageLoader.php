<?php

namespace CreativeSyntax\PageLoader\Traits;

trait PageLoader 
{
    public static function loaderHtml($color = null)
    {
        $html = '
            <div class="seg-loader" style="position:absolute; top:0px; left:0px; right: 0px; bottom: 0px; width:100%; height:100%; background-color:#fff; z-index:99999;">
                <div class="loader-container" style="margin:140px auto; text-align:center;">' . self::loaders($color) . '</div>
            </div>
            <script>        
                document.addEventListener("DOMContentLoaded", hidePHPLoadingIndicator);
                function hidePHPLoadingIndicator() {
                    setTimeout(() => {document.getElementsByClassName("seg-loader")[0].remove();}, 3000);
                }
            </script>';

        $html = self::compressHtml($html);
        return $html;
    }

    public static function loaders($bgColor = '#0277BD')
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="165px" height="165px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
        <circle cx="50" cy="50" fill="none" stroke="' . $bgColor . '" stroke-width="8" r="30" stroke-dasharray="141.37166941154067 49.12388980384689">
          <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
        </circle>';
    }

    public static function compressHtml($html) 
    {
        ini_set('pcre.recursion_limit', '16777');
        @ini_set('zlib.output_compression', 'On');

        $regEx = '%# Collapse whitespace everywhere but in blacklisted elements.
        (?>             # Match all whitespans other than single space.
          [^\S ]\s*     # Either one [\t\r\n\f\v] and zero or more ws,
        | \s{2,}        # or two or more consecutive-any-whitespace.
        ) # Note: The remaining regex consumes no text at all...
        (?=             # Ensure we are not in a blacklist tag.
          [^<]*+        # Either zero or more non-"<" {normal*}
          (?:           # Begin {(special normal*)*} construct
            <           # or a < starting a non-blacklist tag.
            (?!/?(?:textarea|pre)\b)
            [^<]*+      # more non-"<" {normal*}
          )*+           # Finish "unrolling-the-loop"
          (?:           # Begin alternation group.
            <           # Either a blacklist start tag.
            (?>textarea|pre)\b
          | \z          # or end of file.
          )             # End alternation group.
        )  # If we made it here, we are not in a blacklist tag.
        %Six';

        $compressed = preg_replace($regEx, ' ', $html);

        if ($compressed !== null) {
            $html = $compressed;
        }

        return trim($html);
    }
}