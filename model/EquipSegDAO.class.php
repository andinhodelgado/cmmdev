<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once('../dbutil/OCI.class.php');
/**
 * Description of EquipSegDAO
 *
 * @author anderson
 */
class EquipSegDAO extends OCI {

    public function dados() {

        $select = " SELECT "
                        . " E.EQUIP_ID AS \"idEquip\" "
                        . " , E.NRO_EQUIP AS \"nroEquip\" "
                        . " , E.CLASSOPER_CD AS \"codClasseEquip\" "
                        . " , CARACTER(E.CLASSOPER_DESCR) AS \"descrClasseEquip\" "
                        . " , " 
                        . " CASE "
                            . " WHEN R.TP_EQUIP = 1 THEN 1 "
                            . " WHEN E.CLASSOPER_CD IN (4, 23, 227) THEN 2 "
                            . " WHEN E.CLASSOPER_CD IN (9, 6) THEN 3 "
                            . " WHEN E.CLASSOPER_CD = 211 OR R.TP_EQUIP = 2 THEN 4 "
                            . " WHEN E.CLASSOPER_CD = 35 THEN 5 "
                            . " WHEN E.CLASSOPER_CD IN (5, 21, 36, 216) THEN 6 "
                        . " END AS \"tipoEquip\" "
                    . " FROM "
                        . " V_EQUIP E "
                        . " , USINAS.ROLAO R "
                    . " WHERE "
                        . " E.EQUIP_ID = R.EQUIP_ID(+) "
                        . " AND " 
                        . " (R.TP_EQUIP IN (1, 2) "
                        . " OR " 
                        . " E.CLASSOPER_CD IN (4, 5, 9, 6, 21, 23, 35, 36, 211, 216, 227)) ";
        
        $this->Conn = parent::getConn();
        $statement = oci_parse($this->Conn, $select);
        oci_execute($statement);
        oci_fetch_all($statement, $result, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        oci_free_statement($statement);
        return $result;
        
    }
    
}
