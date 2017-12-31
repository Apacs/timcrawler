<?php

$debug = true;
$file = '/var/www/html/result.json';

if($debug)
{
  error_reporting(E_ALL);
}

// result or crawl

if(is_array($_GET) && array_key_exists('action', $_GET) && $_GET['action'] == 'crawl')
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
    5096,
    8784,
    442
  );

  asort($idstodo);

  // do the job
  $calculated = new StdClass();
  $result = new StdClass();

  $item = new StdClass();
  $items = new StdClass();

  foreach($idstodo as $id)
  {
    //$calculated = calculateData(getData($id));
    //$result->{'item' . $id} = $calculated->item;

    $item = getData($id);
    $item = price2Int($item);
    $items->{'item' . $id} = $item->item;
  }

  $items = calculateData($items);
  saveItems($items);

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
        // echo $jsondata;
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

  require_once('view/viewhtml.php');
  $out = new viewhtml;
  $out->viewlist(json_decode($jsondata));
}

# do crawl

function getData($itemID)
{
  $baseurl = 'http://services.runescape.com/m=itemdb_oldschool/';
  $itemuri = 'api/catalogue/detail.json?item=' . $itemID;
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
function calculateData($items)
{
  $newobject = new StdClass();
  //$id = $items->item->id;

  foreach($items as $item)
  {
    switch($item->id)
    {
      case 4151:
        //$newprice = $items->$id->current->price + $items->item4131->current->price;
        break;

      case 4131:
        //$newarray[$id] = $resultarray;
        break;

      default:
        //$newarray[$id] = $resultarray;
        break;
    }
  }

  return $items;
}

function price2Int($item)
{
  $price = $item->item->current->price;

  if(strpos($price, 'k'))
  {
    if(strpos($price, '.') || strpos($price, ','))
    {
      $item->item->current->price = str_replace('k', '00', $item->item->current->price);
    }
    else
    {
      $item->item->current->price = str_replace('k', '000', $item->item->current->price);
    }
  }
  elseif(strpos($price, 'm'))
  {
    if(strpos($price, '.') || strpos($price, ','))
    {
      $item->item->current->price = str_replace('m', '00000', $item->item->current->price);
    }
    else
    {
      $item->item->current->price = str_replace('m', '000000', $item->item->current->price);
    }
  }

  $item->item->current->price = str_replace('.', '', $item->item->current->price);
  $item->item->current->price = str_replace(',', '', $item->item->current->price);

  $item->item->current->price = intval($item->item->current->price);

  return $item;
}

// store data
function saveItems($result)
{
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
