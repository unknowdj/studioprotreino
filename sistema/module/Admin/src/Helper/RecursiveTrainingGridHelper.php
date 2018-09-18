<?php

namespace Admin\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class RecursiveFeatureGridHelper
 * @package Admin\Helper
 */
class RecursiveTrainingGridHelper extends AbstractHelper
{
    public function __invoke($view, $parentId, $data = array(), $params)
    {
        $rows = $this->prepareDataGrid($data, $parentId);
        $res = '<table class="table table-middle">';
        $res .= '<thead>';
        $res .= '<tr>';
        $res .= '<th>' . $view->translate('Name') . '</th>';
        $res .= '<th width="100">' . $view->translate('Add') . '</th>';
        $res .= '<th width="100">' . $view->translate('Active') . '</th>';
        $res .= '<th width="100"></th>';
        $res .= '</tr>';
        $res .= '</thead>';
        $res .= '<tbody>';
        foreach ($rows[0] as $row):
            $res .= $this->getTableContent($view, $parentId, $params, $rows, $row);
        endforeach;
        $res .= '</tbody>';
        $res .= '</table>';
        return $res;
    }

    public function prepareDataGrid($data, $parentId)
    {
        $rows = array();
        foreach ($data as $row) :
            $rows[(int)$row[$parentId]][(int)$row['id']] = $row;
        endforeach;
        return $rows;
    }

    public function GridRow($parentId, $params = array(), $rows = array(), $idPai = 0, $nivel = 0, $lns = '', $tr = '')
    {
        $colors = ['active', 'success', 'warning', 'danger', 'active'];
        if (!empty($rows) && isset($rows[$idPai])):
            $tr = '<tr class="' . $colors[$nivel] . '">';
            $lns = $this->getIcon($idPai, $lns);
            foreach ($rows[$idPai] as $idRow => $rowItem):
                $tr .= $this->getTitle($rowItem, $parentId, $lns);
                ($idPai > 0) ? $tr .= '<td></td>' : $tr .= '<td><a href="' . $params['url_add'] . '/' . $rowItem['id'] . '" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></a> </td>';
                $tr .= '<td>' . StatusActiveHelper::getStatus($rowItem['active']) . '</td>';
                $tr .= '<td class="actions">';
                $tr .= '<a href="' . $params['url_edit'] . '/' . $rowItem['id'] . '" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span></a> ';
                $tr .= '</td>';
                if (isset($rows[$idRow])):
                    $tr .= '</tr>';
                    $tr .= $this->GridRow($parentId, $params, $rows, $idRow, ++$nivel, $lns, $tr);
                    $nivel--;
                else:
                    $tr .= '</tr><tr class="' . $colors[$nivel] . '">';
                endif;
            endforeach;
            $tr .= '</tr>';
            return $tr;
        endif;
    }

    public function getTitle($rowItem, $parentId, $lns)
    {
        if ($rowItem[$parentId] == 0) {
            $tr = '<td><b>' . $lns . $rowItem['title'] . '</b></td>';
        } else {
            $tr = '<td>' . $lns . $rowItem['title'] . '</td>';
        }
        return $tr;
    }

    public function getIcon($idPai, $lns)
    {
        if ($idPai) {
            $lns = '<span class="fa fa-caret-right" style="margin-right: 10px;"></span> ' . $lns;
        }
        return $lns;
    }

    public function getTableContent($view, $parentId, $params, $rows, $row)
    {
        $tr = '<tr>';
        $tr .= '<td>' . $row['title'] . '</td>';
        $tr .= '<td><a href="' . $params['url_add'] . '/' . $row['id'] . '" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></a> </td>';
        $tr .= '<td>' . StatusActiveHelper::getStatus($row['active']) . '</td>';
        $tr .= '<td class="actions">';
        $tr .= '<a href="' . $params['url_edit'] . '/' . $row['id'] . '" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span></a> ';
        $tr .= '</td>';
        $tr .= '</tr>';
        $tr .= $this->GridRow($parentId, $params, $rows, $row['id']);
        return $tr;
    }

}
