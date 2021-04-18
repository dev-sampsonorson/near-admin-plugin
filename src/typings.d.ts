interface Element {
    matchesSelector(selectors: string): boolean;
    mozMatchesSelector(selectors: string): boolean;
    msMatchesSelector(selectors: string): boolean;
    oMatchesSelector(selectors: string): boolean;
}

interface JQuery {
    parsley(options?: any): any;
    datepicker(options?: any): any;
    alert(options?: any): any;
    modal(options?: any): any;
}


declare const frontend_script_config: {
    publicKey: string;
    ajaxRequestUrl: string;
    saveVolunteerFormNonce: string;
    saveScholarshipFormNonce: string;
    saveDonationNonce: string;
    generatePaymentRefNonce: string;
    verifyTransactionNonce: string;
};

declare const backend_script_config: {
    ajaxRequestUrl: string;
    getRecordInfoNonce: string;
};

declare const PaystackPop: any;

declare var window: Window;