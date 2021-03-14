const Parsley = require('parsleyjs');

import TeboUtility from "../../TeboUtility";
import IFormConfig from "./IFormConfig";
import $ from 'jquery';
import moment from 'moment';
import 'bootstrap-datepicker';
import FormNotification, { NotificationStatus } from "../form-notification/FormNotification";
import FormDataExtractor from '../form-data-extractor/FormDataExtractor';


export default class ScholarshipForm {
    private validationInstance;

    private wrapperEl: HTMLElement;
    private formEl: HTMLFormElement;
    private saveEl: HTMLButtonElement;
    private cancelEl: HTMLButtonElement;

    private fileInputIds: string[];

    private formDataExtractor: FormDataExtractor;
    private notificationEl: FormNotification;

    constructor(private config: IFormConfig) {
        this.wrapperEl = document.querySelector(`#${this.config.formWrapperId}`)! as HTMLElement;
        this.formEl = this.wrapperEl.querySelector(`#${this.config.formId}`)! as HTMLFormElement;
        this.saveEl = this.wrapperEl.querySelector(`#${this.config.saveButtonId}`)! as HTMLButtonElement;
        this.cancelEl = this.wrapperEl.querySelector(`#${this.config.cancelButtonId}`)! as HTMLButtonElement;

        this.fileInputIds = this.config.fileInputIds || [];

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

        this.saveEl.addEventListener('click', e => {
            e.preventDefault();

            const el = e.currentTarget as HTMLElement;
            const isValid = this.validationInstance.validate();


            /* if (!isValid) {
                this.notificationEl.error("Oops, you have not completed the form correctly");
                return true;
            } */

            let inputValues = this.formDataExtractor.toObject(this.formEl);
            let inputAsFormData: FormData = TeboUtility.objectToFormData(inputValues);

            this.fileInputIds.forEach(id => {
                const fileList = (document.getElementById(id) as HTMLInputElement).files;
                if (fileList !== null) {
                    inputAsFormData.append(id, fileList[0]);
                }
            });


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

        Parsley.addValidator('maxFileSize', {
            validateString: function (_value, maxSize, parsleyInstance) {
                if (!FormData) {
                    alert('You are making all developpers in the world cringe. Upgrade your browser!');
                    return true;
                }
                const files = parsleyInstance.$element[0].files;
                return files.length != 1 || files[0].size <= maxSize * 1024;
            },
            requirementType: 'integer',
            messages: {
                en: 'This file should not be larger than %s Kb'
            }
        });

        Parsley.addValidator('allowedFileType', {
            validateString: function (_value, allowedTypes, parsleyInstance) {
                if (!FormData) {
                    alert('You are making all developpers in the world cringe. Upgrade your browser!');
                    return true;
                }

                let dictionary = {
                    'pdf': 'application/pdf',
                    'png': 'image/png'
                };

                const allowedTypesList = allowedTypes.split(',').filter(value => value.trim() !== '');
                const allowedContentTypes = allowedTypesList.map((value, index) => dictionary[value])
                    .filter(value => value !== undefined);

                const files = parsleyInstance.$element[0].files;
                return files.length === 1 && allowedContentTypes.indexOf(files[0].type) > -1;
            },
            requirementType: 'string',
            messages: {
                en: 'This file should be of types (%s)'
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

}