<?php

// Stripe singleton
require(dirname(__FILE__) . '/lib/Octobat.php');

// Utilities
require(dirname(__FILE__) . '/lib/Util/AutoPagingIterator.php');
require(dirname(__FILE__) . '/lib/Util/LoggerInterface.php');
require(dirname(__FILE__) . '/lib/Util/DefaultLogger.php');
require(dirname(__FILE__) . '/lib/Util/RandomGenerator.php');
require(dirname(__FILE__) . '/lib/Util/RequestOptions.php');
require(dirname(__FILE__) . '/lib/Util/Set.php');
require(dirname(__FILE__) . '/lib/Util/Util.php');

// HttpClient
require(dirname(__FILE__) . '/lib/HttpClient/ClientInterface.php');
require(dirname(__FILE__) . '/lib/HttpClient/CurlClient.php');

// Errors
require(dirname(__FILE__) . '/lib/Error/Base.php');
require(dirname(__FILE__) . '/lib/Error/Api.php');
require(dirname(__FILE__) . '/lib/Error/ApiConnection.php');
require(dirname(__FILE__) . '/lib/Error/Authentication.php');
require(dirname(__FILE__) . '/lib/Error/Idempotency.php');
require(dirname(__FILE__) . '/lib/Error/InvalidRequest.php');
require(dirname(__FILE__) . '/lib/Error/Permission.php');
require(dirname(__FILE__) . '/lib/Error/RateLimit.php');
require(dirname(__FILE__) . '/lib/Error/SignatureVerification.php');

// API operations
require(dirname(__FILE__) . '/lib/ApiOperations/All.php');
require(dirname(__FILE__) . '/lib/ApiOperations/Create.php');
require(dirname(__FILE__) . '/lib/ApiOperations/Delete.php');
require(dirname(__FILE__) . '/lib/ApiOperations/NestedResource.php');
require(dirname(__FILE__) . '/lib/ApiOperations/Request.php');
require(dirname(__FILE__) . '/lib/ApiOperations/Retrieve.php');
require(dirname(__FILE__) . '/lib/ApiOperations/Update.php');

// Plumbing
require(dirname(__FILE__) . '/lib/ApiResponse.php');
require(dirname(__FILE__) . '/lib/OctobatObject.php');
require(dirname(__FILE__) . '/lib/ApiRequestor.php');
require(dirname(__FILE__) . '/lib/ApiResource.php');
require(dirname(__FILE__) . '/lib/SingletonApiResource.php');

// Octobat API Resources
require(dirname(__FILE__) . '/lib/BalanceTransaction.php');
require(dirname(__FILE__) . '/lib/Checkout.php');
require(dirname(__FILE__) . '/lib/Collection.php');
require(dirname(__FILE__) . '/lib/Coupon.php');
require(dirname(__FILE__) . '/lib/CreditNote.php');
require(dirname(__FILE__) . '/lib/CreditNoteNumberingSequence.php');
require(dirname(__FILE__) . '/lib/Customer.php');
require(dirname(__FILE__) . '/lib/Document.php');
require(dirname(__FILE__) . '/lib/DocumentEmailTemplate.php');
require(dirname(__FILE__) . '/lib/DocumentLanguage.php');
require(dirname(__FILE__) . '/lib/DocumentTemplate.php');
require(dirname(__FILE__) . '/lib/EmailsSetting.php');
require(dirname(__FILE__) . '/lib/ExportsSetting.php');
require(dirname(__FILE__) . '/lib/Invoice.php');
require(dirname(__FILE__) . '/lib/InvoiceNumberingSequence.php');
require(dirname(__FILE__) . '/lib/Item.php');
require(dirname(__FILE__) . '/lib/PaymentRecipient.php');
require(dirname(__FILE__) . '/lib/PaymentRecipientReference.php');
require(dirname(__FILE__) . '/lib/PaymentSource.php');
require(dirname(__FILE__) . '/lib/Payout.php');
require(dirname(__FILE__) . '/lib/ProformaInvoice.php');
require(dirname(__FILE__) . '/lib/ProformaInvoiceItem.php');
require(dirname(__FILE__) . '/lib/TaxEvidence.php');
require(dirname(__FILE__) . '/lib/TaxEvidenceRequest.php');
require(dirname(__FILE__) . '/lib/TaxRegionSetting.php');
require(dirname(__FILE__) . '/lib/Transaction.php');

// Plaza
require(dirname(__FILE__) . '/lib/Plaza/Account.php');
require(dirname(__FILE__) . '/lib/Plaza/Capability.php');
require(dirname(__FILE__) . '/lib/Plaza/CountrySpec.php');
