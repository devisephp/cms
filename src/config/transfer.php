<?php
return array(

    /*
    |--------------------------------------------------------------------------
    |  Data Transfer Configuration
    |--------------------------------------------------------------------------
    |
    | Defines which database configurations should be used, which
    |
    */
    'config' => array(
        'source_db'      => 'oakwood_legacy',
        'destination_db' => 'mysql',
        'transfers'      => array(

/*
 * Addresses
 * -------------------------
 * Data Count: Confirmed at 57496
 */

           // 'addresses' => array(
           //     'source_table' => 'Addresses',
           //     'source_id'    => 'ad_AddressPk',
           //     'where' => array(
           //        array('ad_Address1','<>',''),
           //        array('ad_Address1','<>','ad_City')
           //      ),
           //     'functions' => array(
           //         'primary' => function($val) {
           //             return ($val == 'primary') ? 1 : 0;
           //         }
           //     ),
           //     'fields'       => array(
           //         'id'               => null,
           //         'street_1'         => 'Addresses.ad_Address1',
           //         'street_2'         => 'Addresses.ad_Address2',
           //         'city'             => 'Addresses.ad_City',
           //         'state'            => 'Addresses.ad_State',
           //         'zip_code'         => 'Addresses.ad_Zip',
           //         'county'           => 'Addresses.ad_County',
           //         'addressable_id'   => 'Addresses.ad_Pointer',
           //         'addressable_type' => 'Addresses.ad_PointerTable',
           //         'primary'          => 'Addresses.ad_AddressType',
           //         'created_at'       => 'Addresses.ad_DateCreated',
           //         'updated_at'       => 'Addresses.ad_DateCreated',
           //     ),
           // ),

/*
 * Auction Lot Item
 * -------------------------
 * Data Count: Confirmed at 382524
 */

           // 'auction_lot_item' => array(
           //     'source_table' => 'CarNoLane_copy',
           //     'source_id'    => 'cl_NoLanePk',
           //     'source_db_relations' => array(
           //         'SaleDate' => array(
           //             'type'    => 'leftJoin',
           //             'local'   => 'cl_SaleDate',
           //             'foreign' => 'sd_SaleDate'
           //         )
           //     ),
           //     'mysql_functions' => array(
           //         'run_number' => DB::raw("CONCAT(CarNoLane_copy.cl_Lane, '', CarNoLane_copy.cl_No) as run_number")
           //     ),
           //     'functions' => array(
           //         'sold' => function($val) {
           //             return ($val == 'Y') ? 1 : 0;
           //         }
           //     ),
           //     'fields'       => array(
           //         'id'          => 'CarNoLane_copy.cl_NoLanePk',
           //         'auction_id'  => 'SaleDate.sd_SalePK',
           //         'lot_item_id' => 'CarNoLane_copy.cl_CarPk',
           //         'run_number'  => null,
           //         'sold'        => 'CarNoLane_copy.cl_Sold',
           //         'created_at'  => 'CarNoLane_copy.cl_DateCreated',
           //         'updated_at'  => 'CarNoLane_copy.cl_DateModified',
           //     ),
           // ),


/*
 * Auctions
 * -------------------------
 */

//            'auctions' => array(
//                'source_table' => 'SaleDate',
//                'functions' => array(
//                    'open' => function() { return 0; }
//                ),
//                'fields'       => array(
//                    'id'              => 'sd_SalePK',
//                    'date'            => 'sd_SaleDate',
//                    'open'            => null,
//                    'created_at'      => 'sd_SaleDate',
//                    'updated_at'      => 'sd_SaleDate',
//                ),
//            ),

/*
 * Buyers
 * -------------------------
 *
 */

           // 'buyers' => array(
           //     'source_table' => 'CarNoLane_copy',
           //     'source_id'    => 'cl_NoLanePk',
           //     'group_by'     => 'CarNoLane_copy.cl_NoLanePk',
           //     'where'        => array('CarNoLane_copy.cl_Sold','=','Y'),
           //     'distinct' => true,
           //     'source_db_relations' => array(
           //         'SaleDate' => array(
           //             'type'    => 'leftJoin',
           //             'local'   => 'cl_SaleDate',
           //             'foreign' => 'sd_SaleDate'
           //         ),
           //         'CancelSale' => array(
           //             'type'    => 'leftJoin',
           //             'local'   => 'cl_NoLanePk',
           //             'foreign' => 'cns_NoLaneFk'
           //         )
           //     ),
           //     'functions' => array(
           //         'cancelled' => function($val) {
           //             return ($val == 'Y') ? 1 : 0;
           //         },
           //        'cancelled_date' => function($val) {
           //          return date('Y-m-d H:i:s', strtotime($val));
           //        }
           //     ),
           //     'fields'       => array(
           //         'id'                      => 'CarNoLane_copy.cl_NoLanePk',
           //         'auction_id'              => 'SaleDate.sd_SalePK',
           //         'lot_item_id'             => 'CarNoLane_copy.cl_CarPk',
           //         'representative_id'       => null,
           //         'dealer_id'               => 'CarNoLane_copy.cl_BuyDlrPk',
           //         'cancelled'               => 'CarNoLane_copy.cl_SaleCancelled',
           //         'cancelled_date'          => 'CancelSale.cns_DateCancelled',
           //         'cancelled_by_user_id'    => 'CancelSale.lbm_user_id',
           //         'reason_for_cancellation' => 'CarNoLane_copy.cns_Notes',
           //         'created_at'              => 'CarNoLane_copy.cl_DateSold',
           //         'updated_at'              => 'CarNoLane_copy.cl_DateSold',
           //     ),
           // ),

/*
 * Cars
 * -------------------------
 * Problem - The totals are not matching:
 * On Legacy: SELECT count(*) from Cars GROUP BY `Cars`.`cr_VIN`
 * On Current: select count(*) FROM cars;
 */

           // 'cars' => array(
           //     'source_table' => 'Cars_copy',
           //     'source_id'    => 'cr_CarPk',
           //     'group_by'     => 'Cars_copy.cr_VIN',
           //     'fields'       => array(
           //         'id'              => null,
           //         'vin'             => 'Cars_copy.cr_VIN',
           //         'year'            => 'Cars_copy.cr_CarYear',
           //         'make'            => 'Cars_copy.cr_Make',
           //         'model'           => 'Cars_copy.cr_Model',
           //         'submodel'        => 'Cars_copy.cr_SubModel',
           //         'exterior_color'  => 'Cars_copy.cr_Color',
           //         'body_style'      => 'Cars_copy.cr_BodyStyle',
           //         'code'            => null,
           //         'vehicle_type'    => 'Cars_copy.cr_VehType',
           //         'engine'          => 'Cars_copy.cr_Cylinders',
           //         'transmission'    => 'Cars_copy.cr_Transmission',
           //         'wheel_drive'     => 'Cars_copy.cr_TwoByFourWheelDrive',
           //         'interior_color'  => 'Cars_copy.cr_InteriorColor',
           //         'seats'           => 'Cars_copy.crSeats',
           //         'seat_type'       => 'Cars_copy.crSeatType',
           //         'brake_type'      => 'Cars_copy.crBrakeType',
           //         'roof'            => 'Cars_copy.cr_Roof',
           //         'fuel'            => 'Cars_copy.cr_Fuel',
           //         'ac_type'         => 'Cars_copy.cr_AirCondition',
           //         'radio_type'      => 'Cars_copy.cr_Radio',
           //         'mirror_type'     => null,
           //         'airbag_type'     => null,
           //         'created_at'      => 'Cars_copy.cr_DateCreated',
           //         'updated_at'      => 'Cars_copy.cr_DateModified',
           //     ),
           // ),


/*
 * Charges
 * -------------------------
 * Data Count: Confirmed at 538249
 * Problem - Updated At field seems to be zeroing out
 */
//
           // 'charges' => array(
           //     'source_table' => 'Transactions',
           //     'source_id'    => 'cf_TransPk',
           //     'source_db_relations' => array(
           //         'ChartAccount' => array(
           //             'type'    => 'leftJoin',
           //             'local'   => 'cf_ChartAccountFk',
           //             'foreign' => 'ca_ChartAccountPk'
           //         )
           //     ),
           //     'functions' => array(
           //         'buyer' => function($val) {
           //             return ($val == 'B') ? 1 : 0;
           //         },
           //         'user_id' => function($val) {
           //             if($val == 'AdLib' || $val == 'ChrisR') {
           //                 return 0;
           //             }
           //             return $val;
           //         }
           //     ),
           //     'fields'       => array(
           //         'id'          => 'Transactions.cf_TransPk',
           //         'lot_item_id' => 'Transactions.cf_CarFk',
           //         'user_id'     => 'Transactions.cf_User',
           //         'type'        => 'ChartAccount.ca_GLAccntNo',
           //         'buyer'       => 'Transactions.cf_PaidBy',
           //         'amount'      => 'Transactions.cf_ChargeAmount',
           //         'notes'       => 'Transactions.cf_CFNotes',
           //         'created_at'  => 'Transactions.cf_ChargeDate',
           //         'updated_at'  => 'Transactions.cf_ChargeDate',
           //     ),
           // ),
           
           // 'charges' => array(
           //     'source_table' => 'CarNoLane_copy',
           //     'source_id'    => 'cl_NoLanePk',
           //     'where' => array('cl_Sold','=','Y'),
           //     'functions' => array(
           //         'buyer' => function() {
           //             return 1;
           //         },
           //         'type' => function() {
           //             return 101;
           //         }
           //     ),
           //     'fields'       => array(
           //         'id'          => null,
           //         'lot_item_id' => 'CarNoLane_copy.cl_CarPk',
           //         'user_id'     => null,
           //         'type'        => null,
           //         'buyer'       => null,
           //         'amount'      => 'CarNoLane_copy.cl_SellPrice',
           //         'notes'       => null,
           //         'created_at'  => 'CarNoLane_copy.cl_DateSold',
           //         'updated_at'  => 'CarNoLane_copy.cl_DateSold',
           //     ),
           // ),

/*
 * Consignor Payments
 * -------------------------
 * Data Count: Confirmed at 237883
 */

           // 'consignor_payments' => array(
           //     'source_table' => 'Checkbook',
           //     'source_id'    => 'ck_CheckBookPK',
           //     'functions' => array(
           //         'cleared' => function($val) {
           //             return ($val != null) ? 1 : 0;
           //         },
           //         'void' => function($val) {
           //             return ($val == 'Y') ? 1 : 0;
           //         }
           //     ),
           //     'fields'       => array(
           //         'id'                  => 'Checkbook.ck_CheckBookPK',
           //         'dealer_id'           => 'Checkbook.ck_ConsDlrPk',
           //         'lot_item_id'         => 'Checkbook.ck_CarFk',
           //         'issue_user_id'       => 'Checkbook.lbm_issue_user_id',
           //         'void_user_id'        => 'Checkbook.lbm_void_user_id',
           //         'shipping_carrier_id' => 'Checkbook.ckShipper',
           //         'check_number'        => 'Checkbook.ck_CheckNo',
           //         'printing_date'       => 'Checkbook.ck_CheckDate',
           //         'amount'              => 'Checkbook.ck_CheckAmount',
           //         'void'                => 'Checkbook.ck_Void',
           //         'void_date'           => 'Checkbook.ck_VoidDate',
           //         'void_notes'          => null,
           //         'date_logged_out'     => 'Checkbook.ckDateShipped',
           //         'tracking_number'     => null,
           //         'picked_up_by'        => 'Checkbook.ckTrackingInfo',
           //         'cleared'             => 'Checkbook.ck_DateCleared',
           //         'date_cleared'        => 'Checkbook.ck_DateCleared',
           //         'created_at'          => 'Checkbook.ck_CheckDate',
           //         'updated_at'          => 'Checkbook.ck_CheckDate',
           //     ),
           // ),

/*
 * Phone Contact Methods
 * -------------------------
 * Data Count: Confirmed at 71880
 */

//            'contact_methods' => array(
//                'source_table' => 'Phones',
//                'source_id'    => 'ph_PhonePk',
//                'functions' => array(
//                    'contact_method_type' => function($val) {
//                        if ($val == 'primary') $val = 'Work Phone';
//                        if ($val == 'fax') $val = 'Work Fax';
//                        if ($val == 'home') $val = 'Home Phone';
//                        if ($val == 'cell') $val = 'Mobile Phone';
//                        if ($val == 'pager') $val = 'Mobile Phone';
//
//                        return $val;
//                    },
//                    'primary' => function($val) {
//                        return ($val == 'primary') ? 1 : 0;
//                    }
//                ),
//                'fields'       => array(
//                    'id'                  => null,
//                    'contact_method_type' => 'Phones.ph_Type',
//                    'contactable_type'    => 'Phones.ph_PointerTable',
//                    'contactable_id'      => 'Phones.ph_Pointer',
//                    'value'               => 'Phones.ph_Phone',
//                    'primary'             => 'Phones.ph_Type',
//                    'created_at'          => 'Phones.ph_DateCreated',
//                    'updated_at'          => 'Phones.ph_DateCreated',
//                ),
//            ),

/*
 * Individuals Contact Methods
 * -------------------------
 */

//            'contact_methods' => array(
//                'source_table' => 'Individuals',
//                'source_id'    => 'id_IndivPk',
//                'functions' => array(
//                    'contact_method_type' => function() { return 'Work Email'; },
//                    'contactable_type' => function() { return 'Person'; },
//                    'primary' => function() { return 1; },
//                ),
//                'fields'       => array(
//                    'id'                  => null,
//                    'contact_method_type' => null,
//                    'contactable_type'    => null,
//                    'contactable_id'      => 'Individuals.id_IndivPk',
//                    'value'               => 'Individuals.id_Email1',
//                    'primary'             => null,
//                    'created_at'          => 'Individuals.id_DateCreated',
//                    'updated_at'          => 'Individuals.id_DateCreated',
//                ),
//            ),


/* Dealers
 * -------------------------
 * Data Count: Confirmed at 18654
 * Problem - May error on flooring or run slow b/c of flooring - added after it was run
 */
//            'dealers' => array(
//                'source_table' => 'Dealers',
//                'source_id'    => 'dl_DlrPk',
//                'functions' => array(
//                    'individual' => function($val) {
//                        return ($val > 0) ? 1 : 0;
//                    },
//                    'in_ko_book' => function($val) {
//                        return ($val == 'Y') ? 1 : 0;
//                    }
//                ),
//                'source_db_relations' => array(
//                    'Flooring' => array(
//                        'type'    => 'leftJoin',
//                        'local'   => 'dl_FlooringCo',
//                        'foreign' => 'fl_floorPK'
//                    )
//                ),
//                'mysql_functions' => array(
//                    'notes' => DB::raw("CONCAT(Dealers.dl_CreditNotes, ' ', Dealers.dl_PrivateNotes, ' ', Dealers.dl_KOBookNotes) as notes"),
//                    'bank_phone_number' => DB::raw("CONCAT(Dealers.dl_BankPhoneNo, ' ', Dealers.dl_BankPhoneExt) as bank_phone_number"),
//                    'primary_contact_name' => DB::raw("CONCAT(Dealers.dl_PContactFName, ' ', Dealers.dl_PContactLName) as primary_contact_name"),
//                ),
//                'fields'       => array(
//                    'id'                             => 'Dealers.dl_DlrPk',
//                    'title_shipping_carrier_id'      => 'Dealers.dl_TitleShipperFk',
//                    'checks_shipping_carrier_id'     => 'Dealers.dl_TitleShipperFk',
//                    'individual'                     => 'Dealers.dl_IndivPk',
//                    'type'                           => 'Dealers.dl_TypeCode',
//                    'name'                           => 'Dealers.dl_LegalName',
//                    'dba'                            => 'Dealers.dl_DBAName',
//                    'primary_contact_name'           => null,
//                    'master_tag_number'              => null,
//                    'license_number'                 => 'Dealers.dl_DealerLicenseNo',
//                    'license_expire'                 => 'Dealers.dl_DateLicExpires',
//                    'federal_id'                     => 'Dealers.dl_FederalIDNo',
//                    'resale_tax_number'              => 'Dealers.dl_ResaleTaxNo',
//                    'title_delivery_account_number'  => 'Dealers.dl_DeliveryAcctNo',
//                    'checks_delivery_account_number' => 'Dealers.dl_DeliveryAcctNo',
//                    'notes'                          => null,
//                    'active'                         => null,
//                    'in_ko_book'                     => 'Dealers.dl_InKOBook',
//                    'approved_payment_method'        => 'Dealers.dl_NormalPayType',
//                    'approved_limit'                 => 'Dealers.dl_CreditLimit',
//                    'bank_name'                      => 'Dealers.dl_BankName',
//                    'bank_contact_name'              => 'Dealers.dl_BankContact',
//                    'bank_phone_number'              => null,
//                    'bank_branch_name'               => 'Dealers.dl_BranchName',
//                    'bank_address_1'                 => 'Dealers.dl_BranchAddress1',
//                    'bank_address_2'                 => 'Dealers.dl_BranchAddress2',
//                    'bank_city'                      => 'Dealers.dl_BranchCity',
//                    'bank_state'                     => 'Dealers.dl_BranchState',
//                    'bank_zipcode'                   => 'Dealers.dl_BranchZip',
//                    'insurance_company_name'         => 'Dealers.dl_InsuranceCo',
//                    'insurance_policy_number'        => 'Dealers.dl_PolicyNo',
//                    'insurance_expiration_date'      => 'Dealers.dl_DateInsExpr',
//                    'bonding_company_name'           => 'Dealers.dl_BondingCo',
//                    'bonding_number'                 => 'Dealers.dl_BondNo',
//                    'bonding_expiration_date'        => 'Dealers.dl_DateBondExpr',
//                    'flooring_company_name'          => 'Flooring.fl_Who',
//                    'flooring_account_number'        => null,
//                    'flooring_notes'                 => null,
//                    'reference_1'                    => 'Dealers.dl_Reference1',
//                    'reference_2'                    => 'Dealers.dl_Reference2',
//                    'reference_notes'                => 'Dealers.dl_CreditNotes',
//                    'created_at'                     => 'Dealers.dl_DateCreated',
//                    'updated_at'                     => 'Dealers.dl_DateModified',
//                ),
//            ),

/*
 * Deposits
 * -------------------------
 * Data Count: Confirmed at 4680
 */

//            'deposits' => array(
//                'source_table' => 'Deposits',
//                'source_id'    => 'id',
//                'functions' => array(
//                    'user_id' => function() { return 117; }
//                ),
//                'fields'       => array(
//                    'id'                => 'Deposits.id',
//                    'user_id'           => null,
//                    'date'              => 'Deposits.date',
//                    'check_total'       => 'Deposits.check_total',
//                    'cash_total'        => 'Deposits.cash_total',
//                    'number_of_checks'  => 'Deposits.number_of_checks',
//                    'cash_transactions' => 'Deposits.cash_transactions',
//                    'total'             => 'Deposits.total',
//                    'created_at'        => 'Deposits.created_at',
//                    'updated_at'        => 'Deposits.updated_at',
//                ),
//            ),

/*
 * Lot Item
 * -------------------------
 * Data Count: Not confirmed
 */

            // 'lot_items' => array(
            //     'source_table' => 'Cars',
            //     'source_id'    => 'cr_CarPk',
            //     'group_by'     => 'cr_CarPk',
            //     'functions' => array(
            //         'gate_passed' => function($val) {
            //             return ($val == "Gate Passed Out") ? 1 : 0;
            //         },
            //       'payment_satisfied' => function($val) {
            //        return ($val == 'Y') ? 1 : 0;
            //       },
            //       'payment_satisfied_date' => function($val) {
            //         return date('Y-m-d H:i:s', strtotime($val));
            //       }
            //     ),
            //     'mysql_functions' => array(
            //         'payment_satisfied'      => DB::raw( "MAX(cl_PaidInFull) payment_satisfied" ),
            //         'payment_satisfied_date' => DB::raw( "MAX(cl_DatePaidInFull) payment_satisfied_date" ),
            //         'gate_passed'            => DB::raw( "MIN(cl_StatusFlag) gate_passed" ),
            //         'check_in_date'          => DB::raw( "MAX(cl_DateArrivedOnLot) check_in_date" ),
            //         'check_out_date'         => DB::raw( "MAX(cl_DateCarLeft) check_out_date" ),
            //         'sell_price'             => DB::raw( "MAX(cl_SellPrice) sell_price")
            //     ),
            //     'source_db_relations' => array(
            //         'CarNoLane_copy' => array(
            //             'type'               => 'leftJoin',
            //             'local'              => 'cr_CarPk',
            //             'foreign'            => 'cl_CarPk'
            //         )
            //     ),
            //     'fields'       => array(
            //       'id'                     => 'Cars.cr_CarPk',
            //       'car_id'                 => null,
            //       'dealer_id'              => 'CarNoLane_copy.cl_ConsDlrPk',
            //       'miles'                  => 'Cars.cr_Mileage',
            //       'gate_passed'            => null,
            //       'sell_price'             => null,
            //       'check_in_date'          => null,
            //       'check_out_date'         => null,
            //       'payment_satisfied'      => null,
            //       'payment_satisfied_date' => null,
            //       'created_at'             => 'Cars.cr_DateCreated',
            //       'updated_at'             => 'Cars.cr_DateModified',
            //       'temp_vin'               => 'Cars.cr_VIN',
            //     ),
            // ),

/*
 * Payments
 * -------------------------
 * Data Count: Confirmed at 238286
 */

           // 'payments' => array(
           //     'source_table' => 'BuyerPayment',
           //     'source_id'    => 'cp_CarPayPk',
           //     'functions' => array(
           //         'reversed' => function($val) {
           //             return ($val == 'Y') ? 1 : 0;
           //         },
           //         'cleared' => function($val) {
           //          return ($val !== null && $val !== '0000-00-00 00:00:00' && $val > '0000-00-00 00:00:00') ? 1 : 0;
           //         }
           //     ),
           //     'fields'       => array(
           //         'id'            => 'BuyerPayment.bp_BPaymentPK',
           //         'dealer_id'     => 'BuyerPayment.bp_BuyDlrPk',
           //         'deposit_id'    => 'BuyerPayment.bp_depositNo',
           //         'user_id'       => 'BuyerPayment.lbm_user_id',
           //         'type'          => 'BuyerPayment.lbm_pay_type',
           //         'amount'        => 'BuyerPayment.bp_PaymentAmount',
           //         'check_number'  => 'BuyerPayment.bp_CheckDraftNo',
           //         'reversed'      => 'BuyerPayment.bp_ReversedYN',
           //         'reversed_date' => null,
           //         'notes'         => 'BuyerPayment.bp_BPNotes',
           //         'created_at'    => 'BuyerPayment.bp_DateRecordCreated',
           //         'updated_at'    => 'BuyerPayment.bp_DateRecordCreated',
           //     ),
           // ),

/*
 * People
 * -------------------------
 * Data Count: Confirmed at 23961
 */

//            'people' => array(
//                'source_table' => 'Individuals',
//                'source_id'    => 'id_IndivPk',
//                'functions' => array(
//                    'banned' => function($val) {
//                        return ($val == 'Y') ? 1 : 0;
//                    }
//                ),
//                'fields'       => array(
//                    'id'            => 'Individuals.id_IndivPk',
//                    'first_name'    => 'Individuals.id_FirstName',
//                    'middle_name'   => 'Individuals.id_MiddleName',
//                    'last_name'     => 'Individuals.id_LastName',
//                    'profile_pic'   => null,
//                    'license'       => 'Individuals.id_DriversLicenseNo',
//                    'license_state' => 'Individuals.id_DriversLicState',
//                    'banned'        => 'Individuals.id_BarredYN',
//                    'banned_reason' => 'Individuals.id_Notes',
//                    'date_of_birth' => 'Individuals.id_BirthDate',
//                    'created_at'    => 'Individuals.id_DateCreated',
//                    'updated_at'    => 'Individuals.id_DateCreated',
//                ),
//            ),

/*
 * Representatives
 * -------------------------
 * Data Count: Confirmed at 9885
 */

//            'representatives' => array(
//                'source_table' => 'Reps',
//                'source_id'    => 'rp_RepPk',
//                'fields'       => array(
//                    'id'         => 'Reps.rp_RepPk',
//                    'dealer_id'  => 'Reps.rp_DealerID',
//                    'person_id'  => 'Reps.rp_IndividualID',
//                    'role'       => null,
//                    'notes'      => null,
//                    'created_at' => 'Reps.rp_DateCreated',
//                    'updated_at' => 'Reps.rp_DateCreated',
//                ),
//            ),

/*
 * Shipping Carriers
 * -------------------------
 * Data Count: Confirmed
 */

           // 'shipping_carriers' => array(
           //     'source_table' => 'Shipper',
           //     'source_id'    => 'shShipperPK',
           //     'fields'       => array(
           //         'id'                => 'Shipper.shShipperPK',
           //         'name'              => 'Shipper.shShipperName',
           //         'tracking_url_mask' => null,
           //         'created_at'        => null,
           //         'updated_at'        => null,
           //     ),
           // ),

/*
 * Titles
 * -------------------------
 * Data Count: Confirmed at 382524
 */

           // 'titles' => array(
           //     'source_table' => 'CarNoLane_copy',
           //     'source_id'    => 'cl_CarPk',
           //     'where'        => array('cl_TitleRecvd','=','Y'),
           //     'fields'       => array(
           //         'id'                  => null,
           //         'lot_item_id'         => 'CarNoLane_copy.cl_CarPk',
           //         'shipping_carrier_id' => 'CarNoLane_copy.cl_TitleSentShipper',
           //         'approved_by_user_id' => 'CarNoLane_copy.lbm_user_id',
           //         'state'               => 'CarNoLane_copy.cl_TitleState',
           //         'title_number'        => 'CarNoLane_copy.cl_TitleNo',
           //         'date_logged_out'     => 'CarNoLane_copy.cl_DateTitleMailed',
           //         'tracking_number'     => 'CarNoLane_copy.cl_TitleTrackingNo',
           //         'picked_up_by'        => 'CarNoLane_copy.cl_TitleRecvdBy',
           //         'approved'            => 'CarNoLane_copy.cl_TitleApproved',
           //         'approved_date'       => 'CarNoLane_copy.cl_DateTitleApp',
           //         'rejected'            => 'CarNoLane_copy.cl_TitleApproved',
           //         'rejected_notes'      => null,
           //         'created_at'          => 'CarNoLane_copy.cl_DateCreated',
           //         'updated_at'          => 'CarNoLane_copy.cl_DateModified',
           //     ),
           // ),

/*
 * Users
 * -------------------------
 */

//            'users' => array(
//                'source_table' => 'users_tbl',
//                'source_id'    => 'us_UserPk',
//                'functions' => array(
//                    'activated' => function($val) {
//                        return ($val == 'Y') ? 0 : 1;
//                    }
//                ),
//                'fields'       => array(
//                    'id'             => 'users_tbl.us_UserPk',
//                    'person_id'      => null,
//                    'email'          => 'users_tbl.us_UserName',
//                    'password'       => null,
//                    'activated'      => 'users_tbl.us_Disable',
//                    'activate_code'  => null,
//                    'remember_token' => null,
//                    'created_at'     => null,
//                    'updated_at'     => 'users_tbl.us_LastLoggedOn',
//                    'deleted_at'     => null,
//                ),
//            ),

/*
 * Charge Payments
 * these are records of what charges were included in a payment and how much
 * of the payment was applied to the charge
 * -------------------------
 * Data Count: Confirmed at 538249
 * Problem - Updated At field seems to be zeroing out
 */
//

           // 'charge_payment' => array(
           //     'source_table' => 'CFPayment',
           //     'source_id'    => 'cfp_PayPk',
           //     'where' => array(
           //        array('cfp_SourceFlag','=','P'),
           //      ),
           //     'fields'       => array(
           //         'charge_id'  => 'CFPayment.cfp_TransFk',
           //         'payment_id' => 'CFPayment.cfp_PaySourceFk',
           //         'amount'     => 'CFPayment.cfp_PayAmt',
           //     ),
           // ),

           'charge_payment' => array(
               'source_table' => 'CarPayment',
               'source_id'    => 'cp_CarPayPk',
                'source_db_relations' => array(
                    'CarNoLane_copy' => array(
                        'type'               => 'leftJoin',
                        'local'              => 'cp_CarNoLanePk',
                        'foreign'            => 'cl_NoLanePk'
                    )
                ),
               'fields'       => array(
                   'charge_id'  => null,
                   'payment_id' => 'CarPayment.cp_PaymentPk',
                   'amount'     => 'CarPayment.cp_AmountApplied',
                   'lbm_lot_item_id'     => 'CarNoLane_copy.cl_CarPk',
               ),
           ),

        ),
    ),
);