// import $ from 'jquery';
import ScholarshipForm from './modules/near-forms/ScholarshipForm';
import TeboUtility from './TeboUtility';
import 'bootstrap/js/dist/alert';
import DonationForm from './modules/near-forms/DonationForm';

window.addEventListener('DOMContentLoaded', (event) => {
    if (!TeboUtility.elementExist('#donationWrapper'))
        return;

    const donationForm = new DonationForm({
        formWrapperId: "donationWrapper",
        formId: "donationForm",
        donateButtonId: "btnDonate",
        amountElementId: "ddlAmount",

        notificationFormContainerId: 'donation-form-notification',
        validatableControlSelector: 'input, textarea, select, [data-parsley-require-if], [data-parsley-radio-required]',

        publicKey: frontend_script_config.publicKey,

        doneMessageDisplaySelector: '#donationWrapper .donation__message',
        successMessage: 'Thank you for completing our application form and purchasing our products and services',
        processingMessage: 'Please, wait we are processing your application and payment',


    });

    console.log("DOM fully loaded and parsed");
});