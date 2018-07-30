<?php

App::uses('AppController', 'Controller');

class NotificationsController extends AppController {

    var $name = "Notifications";
    var $disabledAction = array(
        "admin_index",
        "admin_add",
        "admin_edit",
        "admin_multiple_delete",
    );

    function beforeFilter() {
        parent::beforeFilter();
        $this->_setPageInfo("admin_index", "");
        $this->_setPageInfo("admin_add", "");
        $this->_setPageInfo("admin_edit", "");
    }

    function admin_update_notification($id = null) {
        $this->autoRender = false;
        if ($id == 0) {
            
        } else {
            $this->Notification->save([
                "Notification" => [
                    "id" => $id,
                    "seen" => 1
                ],
            ]);
        }
    }

    function cron_task() {
        $this->autoRender = false;
        $view = new View($this);
        $html = $view->loadHelper('Html');
        $baseUrl = Router::url("/", true);
        $gmEmployeeIds = ClassRegistry::init("User")->find("list", [
            "conditions" => [
                "User.user_group_id" => ClassRegistry::init("UserGroup")->translateToId("general_manager"),
            ],
            "fields" => [
                "Account.employee_id",
            ],
            "contain" => [
                "Account"
            ],
        ]);
        $gmAndFinanceManagerEmployeeIds = ClassRegistry::init("User")->find("list", [
            "conditions" => [
                "User.user_group_id" => ClassRegistry::init("UserGroup")->translateToId(["general_manager", "finance_manager"]),
            ],
            "fields" => [
                "Account.employee_id",
            ],
            "contain" => [
                "Account"
            ],
        ]);
        
        // penggajian
        $employeeSalaries = ClassRegistry::init("EmployeeSalary")->find("all",[
            "conditions" => [
                "EmployeeSalary.employee_salary_cashier_status_id" => 1,
                "EmployeeSalary.validate_status_id" => 1
            ],
            "contain" => [
                "Employee" => [
                    "Account" => [
                        "Biodata"
                    ]
                ]
            ]
        ]);
        foreach ($employeeSalaries as $salary) {
            if($salary['Employee']['employee_type_id'] == 1) {
                $employee_type = "harian";
                $url = $baseUrl . "admin/employee_salaries/cashier_confirm_harian";
            } else {
                $employee_type = "bulanan";
                $url = $baseUrl . "admin/employee_salaries/cashier_confirm_bulanan";
            }
            $message = sprintf("Gaji Pegawai %s (NIK:%s) pada tanggal %s hingga tanggal %s menunggu untuk divalidasi", $salary['Employee']['Account']['Biodata']['full_name'], $salary['Employee']['nip'], $html->cvtTanggal($salary["EmployeeSalary"]["start_date_period"]), $html->cvtTanggal($salary["EmployeeSalary"]["end_date_period"]));
            $this->Notification->addNotifications("employee_salary_id", $salary["EmployeeSalary"]["id"], $gmAndFinanceManagerEmployeeIds, $message,  $url);
        }
        
        //pinjaman koperasi
        $employeeDataLoans = ClassRegistry::init("EmployeeDataLoan")->find("all", [
            "conditions" => [
                "EmployeeDataLoan.verify_status_id" => 1,
            ],
            "recursive" => -1,
            "contain" => [
                "Employee" => [
                    "Account" => [
                        "Biodata",
                    ],
                ],
            ],
        ]);
        foreach ($employeeDataLoans as $employeeDataLoan) {
            $message = sprintf("%s (NIK:%s) mengajukan pinjaman sebesar Rp.%s pada tanggal %s", $employeeDataLoan["Employee"]["Account"]["Biodata"]["full_name"], $employeeDataLoan["Employee"]["nip"], ic_rupiah($employeeDataLoan["EmployeeDataLoan"]["amount_loan"]), $html->cvtTanggal($employeeDataLoan["EmployeeDataLoan"]["date"]));
            $this->Notification->addNotifications("employee_data_loan_id", $employeeDataLoan["EmployeeDataLoan"]["id"], $gmEmployeeIds, $message, $baseUrl . "admin/employee_data_loans/index_verify");
        }
        //penjualan
        $sales = ClassRegistry::init("Sale")->find("all", [
            "conditions" => [
                "Sale.verify_status_id" => 1,
            ],
        ]);
        foreach ($sales as $sale) {
            $message = sprintf("Penjualan dengan nomor PO %s pada tanggal %s menunggu untuk divalidasi", $sale["Sale"]["po_number"], $html->cvtTanggal($sale["Sale"]["created"]));
            $this->Notification->addNotifications("sale_id", $sale["Sale"]["id"], $gmEmployeeIds, $message, $baseUrl . "admin/sales/index_validate");
        }
        //request order material pembantu
        $requestOrderMaterialAdditionals = ClassRegistry::init("RequestOrderMaterialAdditional")->find("all", [
            "conditions" => [
                "RequestOrderMaterialAdditional.request_order_material_additional_status_id" => 1,
            ],
            "recursive" => -1,
        ]);
        foreach ($requestOrderMaterialAdditionals as $requestOrderMaterialAdditional) {
            $message = sprintf("Request Order %s pada tanggal %s menunggu untuk divalidasi", $requestOrderMaterialAdditional["RequestOrderMaterialAdditional"]["ro_number"], $html->cvtTanggal($requestOrderMaterialAdditional["RequestOrderMaterialAdditional"]["ro_date"]));
            $this->Notification->addNotifications("request_order_material_additional_id", $requestOrderMaterialAdditional["RequestOrderMaterialAdditional"]["id"], $gmEmployeeIds, $message, $baseUrl . "admin/request_order_material_additionals/validate");
        }
        //purchase order material pembantu
        $purchaseOrderMaterialAdditionals = ClassRegistry::init("PurchaseOrderMaterialAdditional")->find("all", [
            "conditions" => [
                "PurchaseOrderMaterialAdditional.purchase_order_material_additional_status_id" => 1,
            ],
            "recursive" => -1,
        ]);
        foreach ($purchaseOrderMaterialAdditionals as $purchaseOrderMaterialAdditional) {
            $message = sprintf("Purchase Order %s pada tanggal %s menunggu untuk divalidasi", $purchaseOrderMaterialAdditional["PurchaseOrderMaterialAdditional"]["po_number"], $html->cvtTanggal($purchaseOrderMaterialAdditional["PurchaseOrderMaterialAdditional"]["po_date"]));
            $this->Notification->addNotifications("purchase_order_material_additional_id", $purchaseOrderMaterialAdditional["PurchaseOrderMaterialAdditional"]["id"], $gmEmployeeIds, $message, $baseUrl . "admin/purchase_order_material_additionals/validate");
        }
        //Penerimaan Kelebihan
        $debitInvoiceSales = ClassRegistry::init("DebitInvoiceSale")->find("all", [
            "conditions" => [
                "DebitInvoiceSale.verify_status_id" => 1,
            ],
            "contain" => [
                "Sale"
            ]
        ]);
        foreach ($debitInvoiceSales as $debitInvoiceSale) {
            $message = sprintf("Penerimaan Kelebihan dengan nomor PO %s pada tanggal %s menunggu untuk divalidasi", $debitInvoiceSale["Sale"]["po_number"], $html->cvtTanggal($debitInvoiceSale["DebitInvoiceSale"]["created"]));
            $this->Notification->addNotifications("debit_invoice_sale_id", $debitInvoiceSale["DebitInvoiceSale"]["id"], $gmEmployeeIds, $message, $baseUrl . "admin/debit_invoice_sales/index_validate");
        }
        //Pembayaran Hutang Ikan
        $paymentPurchases = ClassRegistry::init("PaymentPurchase")->find("all", [
            "conditions" => [
                "PaymentPurchase.verify_status_id" => 1,
            ],
        ]);
        foreach ($paymentPurchases as $paymentPurchase) {
            $message = sprintf("Pembayaran Hutang Ikan dengan nomor Kwitansi %s pada tanggal %s menunggu untuk divalidasi", $paymentPurchase["PaymentPurchase"]["receipt_number"], $html->cvtTanggal($paymentPurchase["PaymentPurchase"]["created"]));
            $this->Notification->addNotifications("payment_purchase_id", $paymentPurchase["PaymentPurchase"]["id"], $gmEmployeeIds, $message, $baseUrl . "admin/payment_purchases/index_validate");
        }
        //Pembayaran Hutang Material Pembantu
        $paymentPurchaseMaterialAdditionals = ClassRegistry::init("PaymentPurchaseMaterialAdditional")->find("all", [
            "conditions" => [
                "PaymentPurchaseMaterialAdditional.verify_status_id" => 1,
            ],
        ]);
        foreach ($paymentPurchaseMaterialAdditionals as $paymentPurchaseMaterialAdditional) {
            $message = sprintf("Pembayaran Hutang Material Pembantu dengan nomor Kwitansi %s pada tanggal %s menunggu untuk divalidasi", $paymentPurchaseMaterialAdditional["PaymentPurchaseMaterialAdditional"]["receipt_number"], $html->cvtTanggal($paymentPurchaseMaterialAdditional["PaymentPurchaseMaterialAdditional"]["created"]));
            $this->Notification->addNotifications("payment_purchase_material_additional_id", $paymentPurchaseMaterialAdditional["PaymentPurchaseMaterialAdditional"]["id"], $gmEmployeeIds, $message, $baseUrl . "admin/payment_purchase_material_additionals/index_validate");
        }
        //Penerimaan Kembalian Ikan
        $debitInvoicePurchasers = ClassRegistry::init("DebitInvoicePurchaser")->find("all", [
            "conditions" => [
                "DebitInvoicePurchaser.verify_status_id" => 1,
            ],
            "contain" => [
                "TransactionEntry"
            ]
        ]);
        foreach ($debitInvoicePurchasers as $debitInvoicePurchaser) {
            $message = sprintf("Penerimaan Kembalian Ikan dengan nomor Transaksi %s pada tanggal %s menunggu untuk divalidasi", $debitInvoicePurchaser["TransactionEntry"]["transaction_number"], $html->cvtTanggal($debitInvoicePurchaser["DebitInvoicePurchaser"]["created"]));
            $this->Notification->addNotifications("debit_invoice_purchaser_id", $debitInvoicePurchaser["DebitInvoicePurchaser"]["id"], $gmEmployeeIds, $message, $baseUrl . "admin/debit_invoice_purchasers/index_validate");
        }
        //Penerimaan Kembalian Material Pembantu
        $debitInvoicePurchaserMaterialAdditionals = ClassRegistry::init("DebitInvoicePurchaserMaterialAdditional")->find("all", [
            "conditions" => [
                "DebitInvoicePurchaserMaterialAdditional.verify_status_id" => 1,
            ],
            "contain" => [
                "PurchaseOrderMaterialAdditional"
            ]
        ]);
        foreach ($debitInvoicePurchaserMaterialAdditionals as $debitInvoicePurchaserMaterialAdditional) {
            $message = sprintf("Penerimaan Kembalian Material Pembantu dengan nomor PO %s pada tanggal %s menunggu untuk divalidasi", $debitInvoicePurchaserMaterialAdditional["PurchaseOrderMaterialAdditional"]["po_number"], $html->cvtTanggal($debitInvoicePurchaserMaterialAdditional["DebitInvoicePurchaserMaterialAdditional"]["created"]));
            $this->Notification->addNotifications("debit_invoice_purchaser_material_additional_id", $debitInvoicePurchaserMaterialAdditional["DebitInvoicePurchaserMaterialAdditional"]["id"], $gmEmployeeIds, $message, $baseUrl . "admin/debit_invoice_purchaser_material_additionals/index_validate");
        }
        //Permintaan Material Pembantu
        $materialAdditionalPerContainers = ClassRegistry::init("MaterialAdditionalPerContainer")->find("all", [
            "conditions" => [
                "MaterialAdditionalPerContainer.verify_status_id" => 1,
            ],
            "contain" => [
                "Sale"
            ]
        ]);
        foreach ($materialAdditionalPerContainers as $materialAdditionalPerContainer) {
            $message = sprintf("Permintaan Material Pembantu dengan nomor PO %s pada tanggal %s menunggu untuk divalidasi", $materialAdditionalPerContainer["Sale"]["po_number"], $html->cvtTanggal($materialAdditionalPerContainer["MaterialAdditionalPerContainer"]["created"]));
            $this->Notification->addNotifications("material_additional_per_container_id", $materialAdditionalPerContainer["MaterialAdditionalPerContainer"]["id"], $gmEmployeeIds, $message, $baseUrl . "admin/material_additional_per_containers");
        }
        //Notifikassi Konversi Tidak Sesuai Ratio
        $conversions = ClassRegistry::init("Conversion")->find("all", [
            "conditions" => [
                "Conversion.verify_status_id" => 1,
                "Conversion.verify_status_id" => 2,
            ],
        ]);
        foreach ($conversions as $conversion) {
            $message = sprintf("Konversi dengan nomor %s pada tanggal %s menunggu untuk divalidasi", $conversion["Conversion"]["no_conversion"], $html->cvtTanggal($conversion["Conversion"]["created"]));
            $this->Notification->addNotifications("conversion_id", $conversion["Conversion"]["id"], $gmEmployeeIds, $message, $baseUrl . "admin/conversions/index_validate");
        }
        //Notifikassi Styling Tidak Sesuai Ratio
        $freezes = ClassRegistry::init("Freeze")->find("all", [
            "conditions" => [
                "Freeze.verify_status_id" => 1,
                "Freeze.validate_status_id" => 2,
            ],
        ]);
        foreach ($freezes as $freeze) {
            $message = sprintf("Styling dengan nomor %s pada tanggal %s menunggu untuk divalidasi", $freeze["Freeze"]["freeze_number"], $html->cvtTanggal($freeze["Freeze"]["created"]));
            $this->Notification->addNotifications("freeze_id", $freeze["Freeze"]["id"], $gmEmployeeIds, $message, $baseUrl . "admin/freezes/index_validate");
        }
        //Notifikassi Treatment Tidak Sesuai Ratio
        $treatments = ClassRegistry::init("Treatment")->find("all", [
            "conditions" => [
                "Treatment.verify_status_id" => 1,
                "Treatment.validate_status_id" => 2,
            ],
        ]);
        foreach ($treatments as $treatment) {
            $message = sprintf("Treatment dengan nomor %s pada tanggal %s menunggu untuk divalidasi", $treatment["Treatment"]["treatment_number"], $html->cvtTanggal($treatment["Treatment"]["created"]));
            $this->Notification->addNotifications("treatment_id", $treatment["Treatment"]["id"], $gmEmployeeIds, $message, $baseUrl . "admin/treatments/index_validate");
        }
    }

    function cron_send() {
        $this->autoRender = false;
        $this->loadModel("Outbox");
        $notifications = ClassRegistry::init("Notification")->find("all", [
            "conditions" => [
                "OR" => [
                    "Notification.sms" => 0,
                    "Notification.email" => 0,
                ]
            ],
            "contain" => [
                "Employee" => [
                    "Account" => [
                        "Biodata",
                        "User",
                    ],
                ],
            ],
        ]);
        foreach ($notifications as $notification) {
            //sms
            if (!$notification["Notification"]["sms"]) {
                $number = @$notification["Employee"]["Account"]["Biodata"]["handphone"];
                if (!empty($number)) {
                    $this->Outbox->sendMessage($notification["Notification"]["message"], $number);
                }
                $this->Notification->id = $notification["Notification"]["id"];
                $this->Notification->save([
                    "sms" => 1,
                ]);
            }
            //email
            if (!$notification["Notification"]["email"]) {
                $email = @$notification["Employee"]["Account"]["User"]["email"];
                $this->_sentEmail("globalnotification", [
                    "tujuan" => $email,
                    "subject" => "Notification - CWF",
                    "from" => array("noreplychenwoo@gmail.com" => "CWF"),
                    "acc" => "NoReply",
                    "item" => [
                        'full_name' => $notification["Employee"]["Account"]["Biodata"]["full_name"],
                        'message' => $notification["Notification"]["message"],
                        "target" => $notification["Notification"]["target"],
                    ],
                ]);
                $this->Notification->id = $notification["Notification"]["id"];
                $this->Notification->save([
                    "email" => 1,
                ]);
            }
        }
    }

}
