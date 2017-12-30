<?php

$debug = true;
$file = '/var/www/html/result.json';

if($debug)
{
  error_reporting(E_ALL);
}

# result or crawl

if(is_array($_GET) && array_key_exists('action',$_GET) && $_GET['action'] == 'crawl')
{
  processData();
}
else
{
  showResult();
}

exit;

// Logical

function processData()
{
  // read IDs
  $idstodo = array(
    4151,
    4131,
  );

  // do the job
  $processed = array();
  $result = array();

  foreach($idstodo as $id)
  {
    //$processed = getData($id);
    //$result[] = calculateData($processed);
    $result[] = calculateData(getData($id));
  }

  saveResult($result);

  return true;
}

# show result

function showResult()
{
  global $file;
  $jsondata = '';

  try
  {
      if($jsondata = file_get_contents($file))
      {
        echo $jsondata;
      }
      else
      {
        throw new Exception('Daten konnten nicht von ' . $file . ' gelesen werden');
      }
  }
  catch(Exception $e)
  {
    echo $e->getMessage() . ' in ' . $e->getFile() . ', Zeile: ' . $e->getLine() . '.';
  }
}

# do crawl

function getData($itemID)
{
  $baseurl = 'http://services.runescape.com/m=itemdb_oldschool/';
  $itemuri = 'api/catalogue/detail.json?item=' . $itemID;
  // $url = urlencode($baseurl . $itemuri);
  $url = $baseurl . $itemuri;
  $jsondata = '';

  try
  {
    if($jsondata = file_get_contents($url))
    {
        echo 'Daten von API abgefragt.<br />';
        // @TODO: validate response
    }
    else
    {
      throw new Exception('Daten konnten nicht von ' . $url . ' gabgefragt werden');
    }
  }
  catch(Exception $e)
  {
    echo $e->getMessage() . ' in ' . $e->getFile() . ', Zeile: ' . $e->getLine() . '.';
  }

  return json_decode($jsondata);
}

// do the math
function calculateData($resultarray)
{
  $newarray = array();

  // $newarray[] = $resultarray;

  switch($resultarray->item->id)
  {
    case 4151:
      $newarray[] = $resultarray;
      break;

    case 4131:
      $newarray[] = $resultarray;
      break;

    default:
      $newarray[] = $resultarray;
      break;
  }

  return $newarray;
}

// store data
function saveResult($result)
{
  print_r($result);
  exit;

  $jsonresult = json_encode($result, JSON_PRETTY_PRINT);
  global $file;

  try
  {
    if(file_put_contents($file, $jsonresult))
    {
      echo 'Ergebnis gespeichert.<br />';
    }
    else {
      {
        throw new Exception('Ergebnis konnte nicht in ' . $file . ' gespeichert werden');
      }
    }
    }
  catch(Exception $e)
  {
    echo $e->getMessage() . ' in ' . $e->getFile() . ', Zeile: ' . $e->getLine() . '.';
  }

  return true;
}
