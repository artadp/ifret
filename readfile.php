<?php
session_start();
if (!isset($_SESSION["filepath"])) {
    header("Location:./index.html");
}
    $pointer=0;
    //$file="./test.txt";
    $file=$_SESSION["filepath"];
    $file_name=$_SESSION['filename'];
    echo "$file";
    $content=file_get_contents($file);


$prgct=preg_split('/[,.\s;]+/', $content);
    //here comes deleting stopwords
    echo gettype($prgct), "\n";
    $stopwords = array( 'a', 'about', 'above', 'after', 'again', 'against',
    'all', 'am', 'an', 'and', 'any', 'are', "aren't", 'as', 'at', 'be',
    'because', 'been', 'before', 'being', 'below', 'between', 'both', 'but',
    'by', "can't", 'cannot', 'could', "couldn't", 'did', "didn't", 'do', 'does',
    "doesn't", 'doing', "don't", 'down', 'during', 'each', 'few', 'for', 'from',
    'further', 'had', "hadn't", 'has', "hasn't", 'have', "haven't", 'having',
    'he', "he'd", "he'll", "he's", 'her', 'here', "here's", 'hers', 'herself',
    'him', 'himself', 'his', 'how', "how's", 'i', "i'd", "i'll", "i'm", "i've",
    'if', 'in', 'into', 'is', "isn't", 'it', "it's", 'its', 'itself', "let's",
    'me', 'more', 'most', "mustn't", 'my', 'myself', 'no', 'nor', 'not', 'of',
    'off', 'on', 'once', 'only', 'or', 'other', 'ought', 'our', 'ours',
    'ourselves', 'out', 'over', 'own', 'same', "shan't", 'she', "she'd",
    "she'll", "she's", 'should', "shouldn't", 'so', 'some', 'such', 'than',
    'that', "that's", 'the', 'their', 'theirs', 'them', 'themselves', 'then',
    'there', "there's", 'these', 'they', "they'd", "they'll", "they're",
    "they've", 'this', 'those', 'through', 'to', 'too', 'under', 'until', 'up',
    'very', 'was', "wasn't", 'we', "we'd", "we'll", "we're", "we've", 'were',
    "weren't", 'what', "what's", 'when', "when's", 'where', "where's", 'which',
    'while', 'who', "who's", 'whom', 'why', "why's", 'with', "won't", 'would',
    "wouldn't", 'you', "you'd", "you'll", "you're", "you've", 'your', 'yours',
    'yourself', 'yourselves', 'zero'
);
    $cont_nostopwrd=array_diff($prgct, $stopwords);

    //var_dump($cont_nostopwrd);
    $keywords=array();

    foreach ($cont_nostopwrd as $item) {
        $newitem=stem_english($item);//."\n"; //stemming
        $newitem=strtolower($newitem);
        array_push($keywords, $newitem);
    }
    $something=array_shift($keywords);
    $_SESSION['keywords']=$keywords;
    //var_dump($keywords);
    //print_r($keywords);
    //inserting document address to database and getting doc number:

    require 'connect.php';
    echo $db;
    $count=$db->docs->count();
    echo "count: $count";
    $count=$count++;
    $_SESSION['docnum']=$count;

    $record['filename']=$file_name;
    $record['filepath']=$file;
    $record['docnum']=$count;

    $result=$db->docs->insert($record);
    if ($result) {
        echo "\n done";
        header("Location:./insert_index.php");
    }
