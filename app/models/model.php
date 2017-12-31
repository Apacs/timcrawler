<?php

class model
{
  private $idsfile = 'data/ids.dat';
  private $datafile = 'data/result.json';

  public function getids()
  {
    try
    {
      if($ids = file_get_contents($this->idsfile))
      {
        // Daten wurden eingelesen.
      }
      else
      {
        throw new Exception('IDs konnten nicht von ' . $this->idsfile . ' gelesen werden');
      }
    }
    catch(Exception $e)
    {
      echo $e->getMessage() . ' in ' . $e->getFile() . ', Zeile: ' . $e->getLine() . '.';
    }

    return $ids;
  }

  public function savedata($result)
  {
    $jsonresult = json_encode($result, JSON_PRETTY_PRINT);

    try
    {
      if(file_put_contents($this->datafile, $jsonresult))
      {
        echo 'Ergebnis gespeichert.<br />';
      }
      else {
        {
          throw new Exception('Ergebnis konnte nicht in ' . $this->datafile . ' gespeichert werden');
        }
      }
      }
    catch(Exception $e)
    {
      echo $e->getMessage() . ' in ' . $e->getFile() . ', Zeile: ' . $e->getLine() . '.';
    }

    return true;
  }

  public function getdata()
  {
    try
    {
        if($jsondata = file_get_contents($this->datafile))
        {
          // JSON-Daten eingelesen.
        }
        else
        {
          throw new Exception('Daten konnten nicht von ' . $this->datafile . ' gelesen werden');
        }
    }
    catch(Exception $e)
    {
      echo $e->getMessage() . ' in ' . $e->getFile() . ', Zeile: ' . $e->getLine() . '.';
    }

    return $jsondata;
  }

  public function getitems($itemID)
  {
    $baseurl = 'http://services.runescape.com/m=itemdb_oldschool/';
    $itemuri = 'api/catalogue/detail.json?item=' . $itemID;
    $url = $baseurl . $itemuri;
    $jsondata = '';

    try
    {
      if($jsondata = file_get_contents($url))
      {
          echo 'Daten von API für ID ' . $itemID . ' abgefragt.<br />';
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

    return $jsondata;
  }
}
