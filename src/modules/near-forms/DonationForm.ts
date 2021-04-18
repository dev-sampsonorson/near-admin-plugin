const Parsley = require('parsleyjs');

import TeboUtility from "../../TeboUtility";
import IFormConfig from "./IFormConfig";
import $ from 'jquery';
import moment from 'moment';
import 'bootstrap-datepicker';
import FormNotification, { NotificationStatus } from "../form-notification/FormNotification";
import FormDataExtractor from '../form-data-extractor/FormDataExtractor';
import ValidationError from "../app-error/ValidationError";
import IDonationConfig from "./IDonationConfig";
import { collapseTextChangeRangesAcrossMultipleVersions } from "typescript";


export default class DonationForm {
    private validationInstance;

    private wrapperEl: HTMLElement;
    private formEl: HTMLFormElement;
    private donateButtonEl: HTMLButtonElement;
    private amountEl: HTMLSelectElement;
    private publicKey: string;

    private formDataExtractor: FormDataExtractor;
    private notificationEl: FormNotification;

    constructor(private config: IDonationConfig) {
        this.wrapperEl = document.querySelector(`#${this.config.formWrapperId}`)! as HTMLElement;
        this.formEl = this.wrapperEl.querySelector(`#${this.config.formId}`)! as HTMLFormElement;
        this.donateButtonEl = this.wrapperEl.querySelector(`#${this.config.donateButtonId}`)! as HTMLButtonElement;
        this.amountEl = this.wrapperEl.querySelector(`#${this.config.amountElementId}`)! as HTMLSelectElement;

        this.publicKey = this.config.publicKey;
        this.formDataExtractor = new FormDataExtractor();

        this.notificationEl = new FormNotification({
            containerId: this.config.notificationFormContainerId,
            messageElClass: 'alert-message'
        });

        this.validationInstance = $(this.formEl).parsley({
            inputs: this.config.validatableControlSelector
        });

        this.registerCustomValidators();
        this.setup();
    }

    setup() {
        const self = this;

        // console.log($('.alert').alert());

        // Register Events
        this.validationInstance.on('form:error', function () {
            this.fields.forEach((field, key) => {
                if (field.validationResult !== true) {
                    self.updateErrorClass(field.element, true);
                } else {
                    self.updateErrorClass(field.element, false);
                }
            });
        });

        this.validationInstance.on('form:success', function () {
            this.fields.forEach((field, key) => {
                if (field.validationResult === true) {
                    self.updateErrorClass(field.element, false);
                } else {
                    self.updateErrorClass(field.element, true);
                }
            });
        });

        this.validationInstance.on('field:validated', function () {
            // console.log(this.element);
            if (this.validationResult !== true) {
                self.updateErrorClass(this.element, true);
            } else {
                self.updateErrorClass(this.element, false);
            }
        });

        this.amountEl.addEventListener('change', e => {
            e.preventDefault();
            const el = e.currentTarget as HTMLSelectElement;
            const option = el.options[el.selectedIndex];

            if (option.value === 'other') {
                document.getElementById('otherAmountWrapper')?.classList.remove('d-none');
            } else {
                document.getElementById('otherAmountWrapper')?.classList.add('d-none');
            }

        });

        this.donateButtonEl.addEventListener('click', async e => {
            e.preventDefault();

            try {
                this.donateButtonEl.disabled = true;

                const el = e.currentTarget as HTMLElement;
                const isValid = this.validationInstance.validate();

                if (!isValid) {
                    this.notificationEl.error("Oops, you have not completed the form correctly");
                    return true;
                }

                // generate payment reference
                const paymentRef = await this.generatePaymentReference();


                const formData = new FormData();
                const url = frontend_script_config.ajaxRequestUrl;
                const data: any = this.formDataExtractor.toObject(this.formEl);

                const amountToCharge = ((data.ddlAmount === 'other' ? +data.txtOtherAmount : +data.ddlAmount) || 0) * 100;
                const emailAddress = data.txtEmail;
                const donationReason = data.ddlReason;
                const donationNarration = data.txtDonationNarration;

                if (!paymentRef)
                    throw new Error('Unable to process payment');

                if (amountToCharge === 0)
                    throw new Error('Unable to process payment');

                const handler = PaystackPop.setup({
                    key: this.publicKey, // This is your public key only
                    email: emailAddress, // customer email
                    amount: amountToCharge, // the amount charged
                    ref: paymentRef, // generate a random reference number
                    metadata: { // more custom information about the transaction
                        custom_fields: [
                            {}
                        ]
                    },
                    callback: async (response) => {
                        const r1 = await this.verifyTransaction(response.reference);
                        if (!r1.status)
                            throw 'Transaction verification failed';

                        const r2 = await this.saveDonation(data);
                        if (!r2)
                            throw 'Unable to save donation information';

                        this.notificationEl?.show(NotificationStatus.Success, "Your donation is successful!");
                        this.formEl.reset();
                    },
                    onClose: () => {
                        // alert('window closed');
                    }
                });

                handler.openIframe();
            } catch (error) {
                this.notificationEl?.show(NotificationStatus.Danger, "Unable to process your donation, try again after a few minutes");
            } finally {
                this.donateButtonEl.disabled = false;
            }

            e.stopPropagation();
        });

    }

    registerCustomValidators() {
        Parsley.addValidator('requireIf', {
            messages: { en: 'Description required only if option is checked' },
            validateString: (value, requirement, instance) => {
                const conditionalEl = document.querySelector(requirement) as HTMLSelectElement;
                const isSelected = conditionalEl?.value !== '';
                const instanceEl = instance.element as HTMLInputElement;

                if (!isSelected || conditionalEl?.value !== 'other')
                    return true;

                return instanceEl?.value.trim() !== '';
            }
        });
    }
    updateErrorClass(el: HTMLElement, shouldAdd: boolean) {
        const errorClassName = "is-invalid";
        const groupWrapperClassName = "is-group-wrapper";
        const groupTitleClassName = "is-group-title";

        const isMultiple = el.getAttribute('data-parsley-multiple') ? true : false;
        const hasErrorContainer = el.getAttribute('data-parsley-errors-container') ? true : false;
        const hasGroupTitle = el.getAttribute('data-tebo-group-title') ? true : false;

        const groupTitleEl = el.getAttribute('data-tebo-group-title')
            ? this.wrapperEl.querySelector(el.getAttribute('data-tebo-group-title')!) as HTMLElement
            : null;
        const errorContainerEl = el.getAttribute('data-parsley-errors-container')
            ? this.wrapperEl.querySelector(el.getAttribute('data-parsley-errors-container')!) as HTMLElement
            : null;

        const elToAddClasses = errorContainerEl
            ? errorContainerEl : groupTitleEl
                ? groupTitleEl : el;

        if (shouldAdd) {
            elToAddClasses.classList.add(errorClassName);
        } else {
            elToAddClasses.classList.remove(errorClassName);
        }

        if (hasErrorContainer && isMultiple) {
            errorContainerEl?.classList.add(groupWrapperClassName);
        } else {
            errorContainerEl?.classList.remove(groupWrapperClassName);
        }

        if (hasGroupTitle) {
            groupTitleEl?.classList.add(groupTitleClassName);
        } else {
            groupTitleEl?.classList.remove(groupTitleClassName);
        }
    }

    async generatePaymentReference() {
        const data = new FormData();
        const url = frontend_script_config.ajaxRequestUrl;

        data.append("action", "generatePaymentRef");
        data.append("nonce", frontend_script_config.generatePaymentRefNonce);

        const response = await fetch(url, {
            method: "POST",
            body: new URLSearchParams(data as URLSearchParams)
        });

        if (response.status !== 200)
            throw new Error("Unable to process payment");

        const result = (await response.json()).data.result;

        return result?.ref || '';

    }

    async verifyTransaction(paymentReference) {
        const url = frontend_script_config.ajaxRequestUrl + '?action=verifyTransaction&nonce=' + frontend_script_config.verifyTransactionNonce + '&reference=' + paymentReference;

        const response = await fetch(url, {
            method: "GET"
        });

        if (response.status !== 200)
            throw new Error("Unable to process payment");

        const result = (await response.json()).data.result;

        return result;

    }

    async saveDonation(donationData) {
        const data = new FormData();
        const url = frontend_script_config.ajaxRequestUrl;

        data.append("action", "saveDonation");
        data.append("nonce", frontend_script_config.saveDonationNonce);
        data.append("data", JSON.stringify(donationData));

        const response = await fetch(url, {
            method: "POST",
            body: new URLSearchParams(data as URLSearchParams)
        });

        const responseObj = await response.json();
        const responseResult = responseObj.data.result;

        if (response.status !== 200) {
            throw new ValidationError(responseResult.key, responseResult);
        }

        return responseResult;

    }

}