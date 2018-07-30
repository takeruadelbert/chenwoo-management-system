<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class ChenwooHelper extends HtmlHelper {

    var $modelCashTransactionMutation;

    function __construct(\View $View, $settings = array()) {
        $this->modelCashTransactionMutation = ClassRegistry::init("CooperativeTransactionMutation");
        parent::__construct($View, $settings);
    }

    function nomorTransaksiKoperasi($data, $html = true) {
        $code = $data["CooperativeTransactionType"]["code"];
        $lowerCode = strtolower($code);
        $modeName = Inflector::singularize(Inflector::camelize($data["CooperativeTransactionType"]["table_name"]));
        $id = $data[$modeName]["id"];
        $nomorTransaksi = @$data[$modeName][$this->modelCashTransactionMutation->mapNomor[$code]];
        if ($html) {
            if (empty($nomorTransaksi)) {
                echo "-";
            } else {
                ?>
                <a data-toggle="modal" href="<?= Router::url("/admin/popups/content?content=viewcooptransaction-$lowerCode&id={$id}") ?>" data-target="#default-view-coop-transaction"><?= $nomorTransaksi ?></a>
                <?php
            }
        } else {
            if (empty($nomorTransaksi)) {
                return "-";
            } else {
                return $nomorTransaksi;
            }
        }
    }

    function cabangKoperasi($data) {
        $code = $data["CooperativeTransactionType"]["code"];
        $lowerCode = strtolower($code);
        $modeName = Inflector::singularize(Inflector::camelize($data["CooperativeTransactionType"]["table_name"]));
        $id = $data[$modeName]["id"];
        $cabang = @$data[$modeName]["BranchOffice"]['name'];
        if (empty($cabang)) {
            return "-";
        } else {
            return $cabang;
        }
    }

    function getBatchNumber($treatmentDetail) {
        if ($treatmentDetail["Treatment"]["MaterialEntry"]["material_category_id"] == 1) {
            //whole
            return $treatmentDetail["Treatment"]["Freeze"]["Conversion"]["MaterialEntryGradeDetail"][0]["batch_number"];
        } else {
            //colly
            return $treatmentDetail["Treatment"]["MaterialEntry"]["MaterialEntryGrade"][0]["MaterialEntryGradeDetail"][0]["batch_number"];
        }
    }

    function labelBatchNumber($productDetail) {
        return $productDetail["batch_number"] . " | " . date("d/m/Y", strtotime($productDetail['production_date']));
    }

    function jumlahAngsuran($item){
        return $item["EmployeeDataLoan"]["total_installment_paid"].($item["Employee"]["employee_type_id"]==1?" Minggu":" Bulan");

    }
}
