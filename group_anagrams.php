<?php

/**
 * Group Anagrams
 * 
 * Problem: Given an array of strings, group the anagrams together.
 * 
 * Approach: Use an optimized approach
 * 
 * Algorithm:
 * 1. For each string, sort its characters to create a key
 * 2. All anagrams will have the same sorted key
 * 3. Use hash map to group strings by their sorted key
 * 4. Return the grouped values
 */

function groupAnagrams($strs) {
    $groups = [];
    
    foreach ($strs as $str) {
        
        // Convert string to array of characters
        $chars = str_split($str);
        // Sort the characters
        sort($chars);
        // Create a key from the sorted characters
        $key = implode('', $chars);
        
        // Group by the sorted key
        $groups[$key][] = $str;
    }
    
    // Return only the grouped values
    return array_values($groups);
}

$input = ["eat", "tea", "tan", "ate", "nat", "bat"];
$result = groupAnagrams($input);

echo "<h1>Group Anagrams</h1>";
echo "<p><strong>Input:</strong> [" . implode(', ', array_map(function($s) { return '"' . $s . '"'; }, $input)) . "]</p>";
echo "<p><strong>Output:</strong></p>";

echo "<pre>";
foreach ($result as $group) {
    echo "[" . implode(', ', array_map(function($s) { return '"' . $s . '"'; }, $group)) . "]" . PHP_EOL;
}
echo "</pre>";
