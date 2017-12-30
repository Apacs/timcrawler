<?php

class viewhtml
{
    public function viewlist($dataobject)
    {
      $html = '';

      foreach ($dataobject as $id => $item)
      {
        $html .= $item->id;
      }

      return $html;
    }
}
