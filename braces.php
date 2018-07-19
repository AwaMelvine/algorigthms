<?php
function Braces($arrStr) {
  $results = [];

  $ALL_BRACES = ")]}{[(";
  $OPEN = "{[(";
  $CLOSE = ")]}";

  $refMap = [
    '}' => '{',
    '{' => '}',
    '[' => ']',
    ']' => '[',
    '(' => ')',
    ')' => '('
  ];


  for ($i = 0; $i < sizeof($arrStr); $i++) {
    $valueS = $arrStr[$i]; // loop through string array
    $opened = []; // $opened is a record of all opened braces in order of appearance

    // hash map for each $valueS
    // if a brace is opened, 1 is subtracted from its value
    // if that braces other pair is closed, 1 is added to it's value, normalizing it back to 0
    $map = [
      '}' => 0,
      '{' => 0,
      '[' => 0,
      ']' => 0,
      '(' => 0,
      ')' => 0
    ];

    for ($j = 0; $j < strlen($valueS); $j++) { // looping through each character of $valueS
        $char = substr($valueS, $j, 1); // current character

        if(strpos($ALL_BRACES, $char) !== false) { // if current character is a brace
          $otherPair = $refMap[$char];

          // if open, set to 0, if close, set to 1
          if(strpos($OPEN, $char) !== false) { // OPENING A BRACE
            array_push($opened, $char);
            $map[$char] = $map[$otherPair] - 1; // subtracting 1 from map's value for $char means opening $char
          } else if(strpos($CLOSE, $char) !== false) { // CLOSING A BRACE
            $recentlyOpened = array_slice($opened, sizeof($opened) - 1)[0];

            if($recentlyOpened !== $otherPair) { // the closing $char must be the counter pair ($otherPair) of the most recently opened
              // braces don't match and won't match for $valueS
              $map[$otherPair] += 1;
              break;
            } else if($map[$otherPair] >= $map[$char]) { // closing a brace that has never been opened
              // braces don't match and won't match for $valueS
              $map[$otherPair] += 1;
              break;
            }
            $map[$otherPair] = $map[$otherPair] + 1; // closing means adding the $otherPair (previously opened by subtracting 1)
          }
        }
    }

    // For braces to match in current string, the sum of map values ($mapValuesSum) must be 0
    // since closing and opening was done by alternately subtracting and adding 1
    $mapValuesSum = array_sum(array_values($map));

    if ($mapValuesSum !== 0) {
      array_push($results, [$i => "No"]);
    } else {
      array_push($results, [$i => "Yes"]);
    }

  }
  echo "<pre>"; print_r($results); echo "</pre>";
  return $results;
}

Braces(["t()(){}", "t()(){}", "t()(){(})", "t()(){}"]);
