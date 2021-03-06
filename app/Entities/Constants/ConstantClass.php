<?php
namespace ERP\Entities\Constants;
use stdClass;
use Carbon;
/**
 *
 * @author Reema Patel<reema.p@siliconbrain.in>
 */
class ConstantClass 
{
	/**
	 * making an array contains constant data 
	 * @param (no parameter)
	*/
    public function constantVariable()
	{
		$constantArray = array();
		$constantArray['token'] = "authenticationToken";
		$constantArray['success'] = "Success";
		$constantArray['barcodeWidth'] = 1.5;
		$constantArray['barcodeHeight'] = 60;
		$constantArray['barcodeSetting'] = "barcode";
		$constantArray['chequeNoSetting'] = "chequeno";
		$constantArray['birthDateReminderSetting'] = "birthreminder";
		$constantArray['anniDateReminderSetting'] = "annireminder";
		$constantArray['paymentDateSetting'] = "paymentdate";
		$constantArray['serviceDateSetting'] = "servicedate";
		$constantArray['productSetting'] = "product";
		$constantArray['clientSetting'] = "client";
		$constantArray['billSetting'] = "bill";
		$constantArray['advanceBillSetting'] = "advance";
		$constantArray['inventorySetting'] = "inventory";
		$constantArray['languageSetting'] = "language";
		$constantArray['taxationSetting'] = "taxation";
		$constantArray['workFlowSetting'] = "workflow";
		$constantArray['webIntegrationSetting'] = "webintegration";
		$constantArray['noImage'] = "Storage/No-Image/no-image.jpg";
		$constantArray['productBarcode'] = "Storage/Barcode/";
		$constantArray['documentUrl'] = "Storage/Document/";
		$constantArray['productDocumentUrl'] = "Storage/Product/Document/";
		$constantArray['productCoverDocumentUrl'] = "Storage/Product/Document/CoverImage/";
		$constantArray['emailDocumentUrl'] = "Storage/Email/";
		$constantArray['purchaseTaxationUrl'] = "Storage/Taxation/PurchaseDetail/";
		$constantArray['purchaseTaxUrl'] = "Storage/Taxation/PurchaseTax/";
		$constantArray['taxReturnUrl'] = "Storage/Taxation/GstReturn/";
		$constantArray['taxHtmlUrl'] = "Storage/Taxation/GstHtmlFile/";
		$constantArray['saleTaxUrl'] = "Storage/Taxation/SaleTax/";
		$constantArray['mainLogo'] = "Storage/Logo/";
		$constantArray['polishReportUrl'] = "Storage/Reports/Polish-Report/";
		$constantArray['billDocumentUrl'] = "Storage/Bill/Document/";
		$constantArray['journalDocumentUrl'] = "Storage/Journal/";
		$constantArray['billUrl']="Storage/Bill/";
		$constantArray['multipleBillUrl']="Storage/Bill/Multiple/";
		$constantArray['purchaseBillDocUrl'] = "Storage/PurchaseBill/Document/";
		$constantArray['purchaseBillUrl'] = "Storage/PurchaseBill/";
		$constantArray['quotationDocUrl']="Storage/Quotation/";
		$constantArray['jobFormDocUrl']="Storage/Crm/JobForm";
		$constantArray['profitLossPdf']="Storage/ProfitLoss/Pdf/";
		$constantArray['profitLossExcel']="Storage/ProfitLoss/Excel/";
		$constantArray['cashFlowPdf']="Storage/CashFlow/Pdf/";
		$constantArray['cashFlowExcel']="Storage/CashFlow/Excel/";
		$constantArray['trialBalancePdf']="Storage/TrialBalance/Pdf/";
		$constantArray['trialBalanceExcel']="Storage/TrialBalance/Excel/";
		$constantArray['balanceSheetPdf']="Storage/BalanceSheet/Pdf/";
		$constantArray['balanceSheetExcel']="Storage/BalanceSheet/Excel/";
		$constantArray['stockUrlExcel']="Storage/StockRegister/Excel/";
		$constantArray['stockUrlPdf']="Storage/StockRegister/Pdf/";
		$constantArray['priceListExcel']="Storage/PriceList/Excel/";
		$constantArray['priceListPdf']="Storage/PriceList/Pdf/";
		$constantArray['contactNo']="contact_no";
		$constantArray['openingBalance']="opening";
		$constantArray['postMethod']="POST";
		$constantArray['getMethod']="get";
		$constantArray['deleteMethod']="DELETE";
		$constantArray['journalInward']="Inward";
		$constantArray['journalOutward']="Outward";
		$constantArray['credit']="credit";
		$constantArray['debit']="debit";
		$constantArray['percentage']="percentage";
		$constantArray['ledgerGroupSundryDebitors']="32";
		$constantArray['ledgerGroupSundryCreditors']="31";
		$constantArray['Flatdiscount']="flat";
		$constantArray['operation']="pdf";
		$constantArray['operationExcel']="excel";
		$constantArray['cashLedger']="cash";
		
		//from header data
		$constantArray['sales']="sales";
		$constantArray['wholeSales']="whole_sales";
		$constantArray['purchase']="purchase";
		$constantArray['jfId']="jfid";
		$constantArray['productCode']="productcode";
		$constantArray['fromDate']="fromdate";
		$constantArray['toDate']="todate";
		$constantArray['data']="data";
		$constantArray['type']="type";
		$constantArray['entryDate']="entryDate";
		$constantArray['companyId']="companyId";
		$constantArray['invoiceNumber']="invoiceNumber";
		$constantArray['billNumber']="billNumber";
		$constantArray['tax']="tax";
		$constantArray['inventory']="inventory";
		$constantArray['flag']="flag";
		$constantArray['productName']="productname";
		$constantArray['measurementUnit']="measurement_unit";
		$constantArray['primaryMeasureUnit']="primary_measure_unit";
		$constantArray['isDisplay']="is_display";
		$constantArray['isDisplayYes']="yes";
		$constantArray['transactionDate']="transaction_date";

		$constantArray['userId']="user_id";
		
		
		$constantArray['entry_date']="entry_date";
		$constantArray['company_id']="company_id";
		$constantArray['bill_number']="bill_number";
		$constantArray['invoice_number']="invoice_number";
		$constantArray['branch_id']="branch_id";
		
		//for journal-type
		$constantArray['saleType']="sale";
		$constantArray['salesReturnType']="sales_return";
		$constantArray['purchaseReturnType']="purchase_return";
		$constantArray['purchaseType']="purchase";
		$constantArray['emailType']="email";
		$constantArray['emailSubject']="Cycle Store";
		$constantArray['smsType']="sms";
		$constantArray['blankType']="blank";
		$constantArray['quotationType']="quotation";
		$constantArray['invoice']="invoice";
		$constantArray['paymentType']="payment";
		$constantArray['refundType']="refund";
		$constantArray['receiptType']="receipt";
		$constantArray['specialJournalType']="special_journal";
		$constantArray['fromDate']="fromdate";
		$constantArray['toDate']="todate";

		
		//crm
		$constantArray['conversationEmailType']="email";
		$constantArray['conversationSmsType']="sms";
		$constantArray['prefixConstant']=")]}',\n";
		
		$constantArray['clientUrl']=url('/')."/clients";
		$constantArray['documentGenerateUrl']=url('/')."/documents/bill";
		$constantArray['documentJobformUrl']=url('/')."/crm/job-form";
		$constantArray['documentGenerateQuotationUrl']=url('/')."/accounting/quotations";
		$constantArray['ledgerUrl']=url('/')."/accounting/ledgers";
		$constantArray['journalUrl']=url('/')."/accounting/journals";
		$constantArray['invoiceUrl']=url('/')."/settings/invoice-numbers";
		$constantArray['quotationUrl']=url('/')."/settings/quotation-numbers";
		$constantArray['productUrl']=url('/')."/accounting/products";
		$constantArray['salesBillUrl']=url('/')."/accounting/bills";
		return $constantArray;
	}
	
	/**
	 * making an array contains constant data of template-type
	 * @param (no parameter)
	*/
	public function templateConstants()
	{
		$constantArray = array();
		$constantArray['Invoice'] = "invoice";
		$constantArray['Payment'] = "payment";
		$constantArray['Blank'] = "blank";
		$constantArray['Quotation'] = "quotation";
		$constantArray['Email_NewOrder'] = "email_newOrder";
		$constantArray['Email_DuePayment'] = "email_duePayment";
		$constantArray['Email_BirthDay'] = "email_birthDay";
		$constantArray['Email_AnniversaryDay'] = "email_anniversary";
		$constantArray['Sms_NewOrder'] = "sms_newOrder";
		$constantArray['Sms_DuePayment'] = "sms_duePayment";
		$constantArray['Sms_BirthDay'] = "sms_birthDay";
		$constantArray['Sms_AnniversaryDay'] = "sms_anniversary";

		$constantArray['Thermal_invoice'] = "thermal_invoice";

		return $constantArray;
	}

	/**
	 * making an array contains constant data 
	 * @param (no parameter)
	*/
    public function constantAccountingDate()
	{
		$financialArrayDate = array();
		$mytime = Carbon\Carbon::now();
		$currentDate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $mytime)->format('Y-m-d');
		$dateTime = $mytime->toDateTimeString();
		$yearStartDate = $mytime->year.'-04-01 00:00:00';
		if($dateTime >= $yearStartDate)
		{
			$toYear = $mytime->year+1;
			$financialArrayDate['fromDate'] = $mytime->year.'-04-01 00:00:00';
			$financialArrayDate['toDate'] = $toYear.'-03-31 00:00:00';
		}
		else
		{
			$fromYear = $mytime->year-1;
			$financialArrayDate['fromDate'] = $fromYear.'-04-01 00:00:00';
			$financialArrayDate['toDate'] = $mytime->year.'-03-31 00:00:00';
		}
		return $financialArrayDate;
	}
	
	/**
	 * making an array contains constant data 
	 * @param (no parameter)
	*/
    public function setEmailPassword()
	{
		$mailPasswordArray = array();
		// $mailPasswordArray['emailId'] = 'farhan.s@siliconbrain.in';
		// $mailPasswordArray['password'] = 'Abcd@1234';
		$mailPasswordArray['emailId'] = 'support@swaminarayancycles.com';
		$mailPasswordArray['password'] = 'Abcd@1234';
		return $mailPasswordArray;
	}
	
	/**
	 * making an array contains constant data 
	 * @param (no parameter)
	*/
    public function setSmsPassword()
	{
		$mailPasswordArray = array();
		$mailPasswordArray['user'] = 'swaminarayancycles';
		$mailPasswordArray['password'] = 'demo123';
		$mailPasswordArray['sid'] = 'CYCLES';
		return $mailPasswordArray;
	}
	
	/**
	 * making an array contains comment data 
	 * @param (no parameter)
	*/
    public function getCommentMessage()
	{
		$commentObject = new stdClass();
		// $commentObject->mailSend = "Your Mail Is Successfully Send";
		$commentObject->billMailSend = "Your Mail Is Successfully Send From Sale-Bill";
		$commentObject->quotationMailSend = "Your Mail Is Successfully Send From Quotation";
		$commentObject->crmMailSend = "Your Mail Is Successfully Send From Crm";
		$commentObject->crmSmsSend = "Your Sms Is Successfully Send From Crm";
		$commentObject->emailIdExists = "Entered Email-id is already exists";
		$commentObject->reminderMailSend = "Your Mail Is Successfully Send From Reminder";
		$commentObject->reminderSmsSend = "Your Sms Is Successfully Send From Reminder";
		$commentObject->alreadyMailSend = "Your Mail Is already Successfully Send From Reminder";
		$commentObject->alreadySmsSend = "Your Sms Is already Successfully Send From Reminder";
		return $commentObject;
	}
	
	/**
	 * making an array contains comment data 
	 * @param (no parameter) 
	*/
    public function getReminderTimeForPayment()
	{
		$commentObject = new stdClass();
		// $commentObject->mailSend = "Your Mail Is Successfully Send";
		$commentObject->billMailSend = "Your Mail Is Successfully Send From Sale-Bill";
		$commentObject->quotationMailSend = "Your Mail Is Successfully Send From Quotation";
		$commentObject->crmMailSend = "Your Mail Is Successfully Send From Crm";
		$commentObject->crmSmsSend = "Your Mail Is Successfully Send From Crm";
		$commentObject->emailIdExists = "Entered Email-id is already exists";
		return $commentObject;
	}
	
	/**
	 * making an array contains constant data of Web Integration
	 * @param (no parameter)
	*/
	public function webIntegrationConstants()
	{
		$constantArray = array();
		$constantArray['Authenticate'] = "authenticate";
		$constantArray['Product'] = "products";
		return $constantArray;
	}

	/**
	 *  Dropdown data of Measurement Units for Setting
	 * @param (no parameter)
	*/
	public function measurementTypeConstants()
	{
		$constantArray = array();
		$constantArray['normal'] = "normal";
		$constantArray['advance'] = "Advance Measurement";
		$constantArray['unit'] = "Unit Measurement";
		return $constantArray;
	}

	/**
	 * check the incoming request url and give them respected database name
	 * @param (no parameter)
	*/
	public function constantDatabase()
	{
		 // if(strcmp("http://erp.swaminarayancycles.com/",$_SERVER['HTTP_HOST'])==0)
		 // {
			$database = "mysql";
			return $database;
		 // }
		// else
		// {
			// $database = "mysql_silicon";
			// return $database;
		// }
	}

	/**
	 * check the incoming request url and give them respected database name
	 * @param (no parameter)
	*/
	public function constantDatabaseForCron()
	{
		$database = "mysql";
		return $database;
	}

	/**
	 * making an array contains constant data 
	 * @param (no parameter)
	*/
	public function reportBuilderJoin()
	{
		$constantArray = array();
		// Sales join
		$constantArray['JOIN_SALES_DOC'] = 'LEFT JOIN sales_bill_doc_dtl on sales_bill_doc_dtl.sale_id = sales_bill.sale_id';
		$constantArray['JOIN_SALES_EXPENSE_WITH_EXPENSE'] = "LEFT JOIN sale_expense_dtl on sale_expense_dtl.sale_id = sales_bill.sale_id";
		$constantArray['JOIN_CLIENT_TO_SALES'] = "INNER JOIN client_mst on client_mst.client_id = sales_bill.client_id";
		$constantArray['JOIN_COMPANY_TO_SALES'] = "INNER JOIN company_mst on company_mst.company_id = sales_bill.company_id";
		$constantArray['JOIN_BRANCH_TO_SALES'] = "LEFT JOIN branch_mst on branch_mst.branch_id = sales_bill.branch_id";
		$constantArray['JOIN_USER_TO_SALE'] = "LEFT JOIN user_mst on user_mst.user_id = sales_bill.user_id";
		// Purchase join
		$constantArray['JOIN_PURCHASE_DOC'] = 'LEFT JOIN purchase_doc_dtl on purchase_doc_dtl.purchase_id = purchase_bill.purchase_id';
		$constantArray['JOIN_PURCHASE_EXPENSE_WITH_EXPENSE'] = "LEFT JOIN purchase_expense_dtl on purchase_expense_dtl.purchase_id = purchase_bill.purchase_id";
		$constantArray['JOIN_VENDOR_TO_PURCHASE'] = "INNER JOIN ledger_mst on ledger_mst.ledger_id = purchase_bill.vendor_id";
		$constantArray['JOIN_COMPANY_TO_PURCHASE'] = "INNER JOIN company_mst on company_mst.company_id = purchase_bill.company_id";
		// $constantArray['JOIN_BRANCH_TO_PURCHASE'] = "LEFT JOIN branch_mst on branch_mst.branch_id = purchase_bill.branch_id";
		// Sales Return
		$constantArray['JOIN_SALES_TO_RETURN'] = "INNER JOIN sales_bill on sales_bill.sale_id = sales_return.sale_id";
		$constantArray['JOIN_SALES_DOC_TO_RETURN'] = "LEFT JOIN sales_bill_doc_dtl on sales_bill_doc_dtl.sale_id = sales_return.sale_id";
		$constantArray['JOIN_CLIENT_TO_RETURN'] = "INNER JOIN client_mst on client_mst.client_id = sales_return.client_id";
		$constantArray['JOIN_COMPANY_TO_RETURN'] = "INNER JOIN company_mst on company_mst.company_id = sales_return.company_id";
		$constantArray['JOIN_BRANCH_TO_RETURN'] = "LEFT JOIN branch_mst on branch_mst.branch_id = sales_return.branch_id";
		// Product Joins
		$constantArray['JOIN_PRODUCT_GROUP'] = "LEFT JOIN product_group_mst ON product_group_mst.product_group_id = product_mst.product_group_id";
		$constantArray['JOIN_PRODUCT_CATEGORY'] = "LEFT JOIN product_category_mst ON product_category_mst.product_category_id = product_mst.product_category_id";
		$constantArray['JOIN_PRODUCT_CATEGORY'] = "LEFT JOIN product_category_mst ON product_category_mst.product_category_id = product_mst.product_category_id";
		$constantArray['JOIN_PRODUCT_STOCK_SUMMARY'] = "LEFT JOIN product_trn_summary ON product_trn_summary.product_id = product_mst.product_id";
		$constantArray['JOIN_PRODUCT_STOCK'] = "LEFT JOIN product_trn ON product_trn.product_id = product_mst.product_id";
		$constantArray['JOIN_PRODUCT_COMPANY'] = "INNER JOIN company_mst ON company_mst.company_id = product_mst.company_id";
		$constantArray['JOIN_PRODUCT_BRANCH'] = "LEFT JOIN branch_mst ON branch_mst.branch_id = product_mst.branch_id";
		// Stock Joins
		$constantArray['JOIN_STOCK_TO_SALE'] = "LEFT JOIN sales_bill ON product_trn.jf_id = sales_bill.jf_id";
		$constantArray['JOIN_STOCK_TO_PURCHASE'] = "LEFT JOIN purchase_bill ON product_trn.jf_id = purchase_bill.jf_id";
		// Journal Joins
		$constantArray['JOIN_SALES_TO_JOURNAL'] = "LEFT JOIN sales_bill ON sales_bill.jf_id = journal_dtl.jf_id";
		// User Joins
		$constantArray['JOIN_USER_TO_COMPANY'] = "INNER JOIN company_mst ON company_mst.company_id = user_mst.company_id";
		$constantArray['JOIN_USER_BRANCH'] = "LEFT JOIN branch_mst ON branch_mst.branch_id = user_mst.branch_id";

		return $constantArray;
	}

	/**
	 * making an array contains constant data 
	 * @param (no parameter)
	*/

	public function defaultJoinConditions()
	{
		$constantArray = array();
		$constantArray['JOIN_SALES_DOC'] = '(sales_bill_doc_dtl.deleted_at = 0 OR sales_bill_doc_dtl.sale_id IS NULL) AND ';
		$constantArray['JOIN_SALES_EXPENSE_WITH_EXPENSE'] = "(sale_expense_dtl.deleted_at = 0 OR sale_expense_dtl.sale_id IS NULL) AND ";
		$constantArray['JOIN_CLIENT_TO_SALES'] = "client_mst.deleted_at = 0 AND ";
		$constantArray['JOIN_COMPANY_TO_SALES'] = "company_mst.deleted_at = 0 AND ";
		$constantArray['JOIN_BRANCH_TO_SALES'] = "(branch_mst.deleted_at = 0 OR branch_mst.branch_id IS NULL) AND ";
		$constantArray['JOIN_USER_TO_SALE'] = "((user_mst.deleted_at = 0 AND user_mst.user_type <> 'superadmin') OR user_mst.user_id IS NULL) AND ";
		// Purchase join
		$constantArray['JOIN_PURCHASE_DOC'] = '(purchase_doc_dtl.deleted_at = 0 OR purchase_doc_dtl.purchase_id IS NULL) AND ';
		$constantArray['JOIN_PURCHASE_EXPENSE_WITH_EXPENSE'] = "(purchase_expense_dtl.deleted_at = 0 OR purchase_expense_dtl.purchase_id IS NULL) AND ";
		$constantArray['JOIN_VENDOR_TO_PURCHASE'] = "ledger_mst.deleted_at = 0 AND ";
		$constantArray['JOIN_COMPANY_TO_PURCHASE'] = "company_mst.deleted_at = 0 AND ";
		// $constantArray['JOIN_BRANCH_TO_PURCHASE'] = "(branch_mst.deleted_at = 0 OR branch_mst.branch_id IS NULL) AND ";
		// Sales Return
		$constantArray['JOIN_SALES_TO_RETURN'] = "sales_bill.deleted_at = 0 AND ";
		$constantArray['JOIN_SALES_DOC_TO_RETURN'] = "(sales_bill_doc_dtl.deleted_at = 0 OR sales_bill_doc_dtl.sale_id IS NULL) AND ";
		$constantArray['JOIN_CLIENT_TO_RETURN'] = "client_mst.deleted_at = 0 AND ";
		$constantArray['JOIN_COMPANY_TO_RETURN'] = "company_mst.deleted_at = 0 AND ";
		$constantArray['JOIN_BRANCH_TO_RETURN'] = "(branch_mst.deleted_at = 0 OR branch_mst.branch_id IS NULL) AND ";
		// Products
		$constantArray['JOIN_PRODUCT_GROUP'] = "(product_group_mst.deleted_at = 0 OR product_group_mst.product_group_id IS NULL) AND ";
		$constantArray['JOIN_PRODUCT_CATEGORY'] = "(product_category_mst.deleted_at = 0 OR product_category_mst.product_category_id IS NULL) AND ";
		$constantArray['JOIN_PRODUCT_STOCK_SUMMARY'] = "(product_trn_summary.deleted_at = 0 OR product_trn_summary.product_id IS NULL) AND ";
		$constantArray['JOIN_PRODUCT_STOCK'] = "(product_trn.deleted_at = 0 OR product_trn.product_id IS NULL) AND ";
		$constantArray['JOIN_PRODUCT_COMPANY'] = "company_mst.deleted_at = 0 AND ";
		$constantArray['JOIN_PRODUCT_BRANCH'] = "(branch_mst.deleted_at = 0 OR branch_mst.branch_id IS NULL) AND ";
		// Stock 
		$constantArray['JOIN_STOCK_TO_SALE'] = "(sales_bill.deleted_at = 0 OR sales_bill.sale_id IS NULL) AND ";
		$constantArray['JOIN_STOCK_TO_PURCHASE'] = "(purchase_bill.deleted_at = 0 OR purchase_bill.sale_id IS NULL) AND ";
		// Journal Joins
		$constantArray['JOIN_SALES_TO_JOURNAL'] = "(sales_bill.deleted_at = 0 OR sales_bill.sale_id IS NULL) AND ";
		// User Joins
		$constantArray['JOIN_USER_TO_COMPANY'] = "company_mst.deleted_at = 0 AND ";
		$constantArray['JOIN_USER_BRANCH'] = "(branch_mst.deleted_at = 0 OR branch_mst.branch_id IS NULL) AND ";

		return $constantArray;
	}
}
