<?php

//バリデータ
//引数の数
function validateArguments($args, $expectedCount) {
    if (count($args) !== $expectedCount) {
        echo "Invalid number of arguments.\n";
        exit(1);
    }
}

//ファイルの有無
function validateFileExists($filepath) {
    if (!file_exists($filepath)) {
        echo "File not found: $filepath\n";
        exit(1);
    }
}

//ファイルの有無＆書き込みの可否
function validateIsWritable($filepath) {
    if (file_exists($filepath) && !is_writable($filepath)) {
        echo "File is not writable: $filepath\n";
        exit(1);
    }
}

//ファイル操作
//ファイルの内容を逆順にする
function reverseFile($inputPath, $outputPath) {
    validateFileExists($inputPath);
    validateIsWritable($outputPath);
    
    $contents = file_get_contents($inputPath);
    $reversedContents = strrev($contents);
    file_put_contents($outputPath, $reversedContents);
    echo "File reversed successfully.\n";
}

//input → output コピーする
function copyFile($inputPath, $outputPath) {
    validateFileExists($inputPath);
    validateIsWritable($outputPath);
    
    if (copy($inputPath, $outputPath)) {
        echo "File copied successfully.\n";
    } else {
        echo "Failed to copy file.\n";
    }
}

//ファイルの内容をn回、複製して書き込みする
function duplicateContents($inputPath, $n) {
    validateFileExists($inputPath);
    
    $contents = file_get_contents($inputPath);
    $duplicatedContents = str_repeat($contents, $n);
    file_put_contents($inputPath, $duplicatedContents);
    echo "File contents duplicated $n times successfully.\n";
}

//指定された文字列を新しい文字列に置き換える
function replaceStringInFile($inputPath, $needle, $newString) {
    validateFileExists($inputPath);
    
    $contents = file_get_contents($inputPath);
    $newContents = str_replace($needle, $newString, $contents);
    file_put_contents($inputPath, $newContents);
    echo "String replaced successfully.\n";
}

if ($argc < 2) {
    echo "Usage: php FileManipulator.php <command> [arguments]\n";
    exit(1);
}

$command = $argv[1];

switch ($command) {
    case 'reverse':
        validateArguments($argv, 4);
        reverseFile($argv[2], $argv[3]);
        break;
    case 'copy':
        validateArguments($argv, 4);
        copyFile($argv[2], $argv[3]);
        break;
    case 'duplicate-contents':
        validateArguments($argv, 4);
        if (!is_numeric($argv[3]) || $argv[3] <= 0) {
            echo "The number of times to duplicate must be a positive integer.\n";
            exit(1);
        }
        duplicateContents($argv[2], (int)$argv[3]);
        break;
    case 'replace-string':
        validateArguments($argv, 5);
        replaceStringInFile($argv[2], $argv[3], $argv[4]);
        break;
    default:
        echo "Unknown command: $command\n";
        echo "Available commands: reverse, copy, duplicate-contents, replace-string\n";
        exit(1);
}

?>