<?php

class model
{
  public function getids()
  {
    $file = 'data/ids.dat';

    try
    {
      if($ids = file_get_contents($file))
      {
        // Daten wurden eingelesen.
      }
      else
      {
        throw new Exception('IDs konnten nicht von ' . $file . ' gelesen werden');
      }
    }
    catch(Exception $e)
    {
      echo $e->getMessage() . ' in ' . $e->getFile() . ', Zeile: ' . $e->getLine() . '.';
    }

    return $ids;
  }
}
