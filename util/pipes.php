<?php

function normalizeTextView($text) {
    $text = str_replace("buecher", "bücher", $text);
    $text = str_replace("_", " ", $text);
    $words = explode(" ", $text);
    $uniqueWords = array_unique($words);
    $normalizedText = implode(" ", $uniqueWords);
    return ucwords($normalizedText);
}