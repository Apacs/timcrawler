<?php

require_once('models/model.php');
require_once('views/view.php');

$debug = true;

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
  $dat = new model;
  $idstodo = json_decode($dat->getids());

  // do the job
  $item = new StdClass();
  $items = new StdClass();

  $startzeit = microtime(true);

  foreach($idstodo as $id)
  {
    $item = getData($id);
    $item = price2Int($item);
    $items->{'item' . $id} = $item->item;
  }

  echo '<br />Dauer: ' . (microtime(true) - $startzeit) . '<br>';

  $items = calculateData($items);
  saveItems($items);

  return true;
}

# show result

function showResult()
{
  $data = new model;
  $jsondata = json_decode($data->getdata());

  $out = new view;
  $out->viewlist($jsondata);

  return true;
}

# do crawl

function getData($itemID)
{
  $api = new model;
  $jsondata = $api->getitems($itemID);

  return json_decode($jsondata);
}

// do the math
function calculateData($items)
{
  $newobject = new StdClass();

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
  $data = new model;
  $data->savedata($result);

  return true;
}
