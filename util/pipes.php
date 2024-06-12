<?php

function normalizeTestView($text) {
    $text = str_replace("_", " ", $text);
    return ucwords($text);
}
