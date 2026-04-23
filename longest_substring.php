<?php

/**
 * Longest Substring Without Repeating Characters
 * 
 * Problem: Given a string, find the length of the longest substring without repeating characters.
 * 
 * Approach: Write an efficient solution (O(n) preferred)
 * 
 * Algorithm:
 * 1. Use two pointers (left and right) to define a sliding window
 * 2. Use a hash map to store the last seen index of each character
 * 3. Expand the window by moving right pointer
 * 4. When a duplicate is found, shrink the window from the left
 * 5. Track the maximum window size encountered
 */

function lengthOfLongestSubstring($s) {
    $n = strlen($s);
    if ($n === 0) return ['length' => 0, 'substring' => ''];
    
    // Hash map to store the last index of each character
    $charIndex = [];
    $maxLength = 0;
    $maxSubstring = '';
    $left = 0;
    
    for ($right = 0; $right < $n; $right++) {
        $char = $s[$right];
        
        // If character is already in the window (index >= left), move left pointer
        if (isset($charIndex[$char]) && $charIndex[$char] >= $left) {
            $left = $charIndex[$char] + 1;
        }
        
        // Update the last seen index of the character
        $charIndex[$char] = $right;
        
        // Calculate current window size and update max
        $currentLength = $right - $left + 1;
        if ($currentLength > $maxLength) {
            $maxLength = $currentLength;
            $maxSubstring = substr($s, $left, $maxLength);
        }
    }
    
    return ['length' => $maxLength, 'substring' => $maxSubstring];
}

// Test cases
$testCases = [
    "abcabcbb",
];

echo "<h1>Longest Substring Without Repeating Characters</h1>";

foreach ($testCases as $input) {
    $result = lengthOfLongestSubstring($input);
    echo "<p><strong>Input:</strong> \"" . htmlspecialchars($input) . "\"</p>";
    echo "<p><strong>Output:</strong> " . $result['length'] . "</p>";
    echo "<p><strong>Explanation:</strong> \"" . htmlspecialchars($result['substring']) . "\"</p>";
}