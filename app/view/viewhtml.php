<?php

class viewhtml
{
    public function viewlist($dataobject)
    {
      $html = '<h1>Datenbestand</h1>';
      $html .= '<p>Eine pure Liste aller Objekte, die die Software gemäß Konfiguration abfragt und, sofern angegeben, die Preise berechnet.</p>';

      $html .= '<table class="table table-striped">';
      $html .= '<thead><tr>
                  <th>Icon</th>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Description</th>
                  <th>Current Price (calculated)</th>
                </tr></thead>';

      foreach ($dataobject as $id => $item)
      {
        $html .= '<tr>';

        $html .= '<td><img src="' . $item->icon . '" /></td>';
        $html .= '<td>' . $item->id . '</td>';
        $html .= '<td>' . $item->name . '</td>';
        $html .= '<td>' . $item->description . '</td>';
        $html .= '<td>' . number_format($item->current->price, 0, ',', '.') . '</td>';

        $html .= '</tr>';
      }

      $html .= '</table>';

      return $html;
    }
}
