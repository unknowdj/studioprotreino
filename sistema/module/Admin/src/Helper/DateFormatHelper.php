<?php
namespace Admin\Helper;

use Zend\View\Helper\AbstractHelper;

class DateFormatHelper extends AbstractHelper
{
    public function __invoke($data, $time = 0, $separator = ' - ', $retorno = 0)
    {
        try {
            if (empty($data)) {
                return false;
            }
            $hora = "";
            $dataOld = $data;
            if (!empty($data)) {
                if (strlen($data) > 10) {
                    $hora = $separator . substr($data, 11, 8);
                    $data = substr($data, 0, 10);
                }
                if (strpos($data, '-')) {
                    $p_dt = explode('-', $data);
                    $data = $p_dt[2] . '/' . $p_dt[1] . '/' . $p_dt[0];
                } else {
                    if (strpos($data, '/')) {
                        $p_dt = explode('/', $data);
                        $data = $p_dt[2] . '-' . $p_dt[1] . '-' . $p_dt[0];
                    }
                }
            }
            if ($data === $dataOld) {
                return $retorno;
            }
            if ($time == 1) {
                return $data . $hora;
            } else {
                return $data;
            }
        } catch (Exception $e) {
            return $e;
        }
    }
}