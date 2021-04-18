const Parsley = require('parsleyjs');

import TeboUtility from "../../TeboUtility";
import IFormConfig from "./IFormConfig";
import $ from 'jquery';
import moment from 'moment';
import 'bootstrap-datepicker';
import FormNotification, { NotificationStatus } from "../form-notification/FormNotification";
import FormDataExtractor from '../form-data-extractor/FormDataExtractor';
import ValidationError from "../app-error/ValidationError";


export default class VolunteerForm {
    private validationInstance;

    private wrapperEl: HTMLElement;
    private formEl: HTMLFormElement;
    private saveEl: HTMLButtonElement;
    private cancelEl: HTMLButtonElement;

    private ddlStateOfOriginEl: HTMLInputElement;

    private formDataExtractor: FormDataExtractor;
    private notificationEl: FormNotification;

    constructor(private config: IFormConfig) {
        this.wrapperEl = document.querySelector(`#${this.config.formWrapperId}`)! as HTMLElement;
        this.formEl = this.wrapperEl.querySelector(`#${this.config.formId}`)! as HTMLFormElement;
        this.saveEl = this.wrapperEl.querySelector(`#${this.config.saveButtonId}`)! as HTMLButtonElement;
        this.cancelEl = this.wrapperEl.querySelector(`#${this.config.cancelButtonId}`)! as HTMLButtonElement;

        this.ddlStateOfOriginEl = this.wrapperEl.querySelector(`#ddlStateOfOrigin`)! as HTMLInputElement;

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

        self.loadStateDropdown();

        // Init
        $('.date-control').datepicker({
            format: 'yyyy-mm-dd',
            weekStart: 1,
            daysOfWeekHighlighted: "6,0",
            autoclose: true,
            todayHighlight: true,
        });

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

        this.saveEl.addEventListener('click', async e => {
            e.preventDefault();

            try {
                this.saveEl.disabled = true;

                const el = e.currentTarget as HTMLElement;
                const isValid = this.validationInstance.validate();

                if (!isValid) {
                    this.notificationEl.error("Oops, you have not completed the form correctly");
                    return true;
                }

                const formData = new FormData();
                const url = frontend_script_config.ajaxRequestUrl;
                const data = this.formDataExtractor.toObject(this.formEl);

                formData.append("action", "saveVolunteerForm");
                formData.append("nonce", frontend_script_config.saveVolunteerFormNonce);
                formData.append("data", JSON.stringify(data));

                const response = await fetch(url, {
                    method: "POST",
                    body: new URLSearchParams(formData as URLSearchParams)
                });

                const responseObj = await response.json();
                const responseResult = responseObj.data.result;

                if (response.status !== 200) {
                    throw new ValidationError(responseResult.key, responseResult);
                }

                if (!responseObj.success)
                    throw "Failed to save volunteer";

                this.notificationEl?.show(NotificationStatus.Success, "Successfully saved volunteer");
                this.formEl.reset();
            } catch (err) {
                this.notificationEl?.show(NotificationStatus.Danger, "Unable to save volunteer, check the form for errors and try again.");
            } finally {
                this.saveEl.disabled = false;
            }

            e.stopPropagation();
        });

        this.cancelEl.addEventListener('click', e => {
            const el = e.currentTarget as HTMLElement;

            e.stopPropagation();
        });

    }

    registerCustomValidators() {
        Parsley.addValidator('requireIf', {
            messages: { en: 'Description required only if option is checked' },
            validateString: (value, requirement, instance) => {
                const conditionalEl = document.querySelector(requirement);
                const isConditionalChecked = conditionalEl?.checked;
                const instanceEl = instance.element as HTMLInputElement;

                if (!isConditionalChecked && instanceEl?.value)
                    return false;

                if (!isConditionalChecked)
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

    loadStateDropdown(selectedStateId: number = 0) {
        this.ddlStateOfOriginEl.innerHTML = '';

        let options = `<option ${selectedStateId !== 0 ? '' : 'selected'} disabled value="">Select a state of origin</option>`;

        for (const state of TeboUtility.allStates) {
            let selected = '';
            if (selectedStateId !== 0 && selectedStateId === state.stateId) {
                selected = 'selected';
            }
            options += `<option ${selected} value="${state.stateId}">${state.stateName}</option>`;
        }

        this.ddlStateOfOriginEl?.insertAdjacentHTML('beforeend', options);
        this.ddlStateOfOriginEl?.dispatchEvent(new Event('change'));
    }

}