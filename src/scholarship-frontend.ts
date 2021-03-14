// import $ from 'jquery';
import ScholarshipForm from './modules/near-forms/ScholarshipForm';
import TeboUtility from './TeboUtility';
import 'bootstrap/js/dist/alert';

window.addEventListener('DOMContentLoaded', (event) => {
    const scholarshipForm = new ScholarshipForm({
        formWrapperId: "scholarshipApplicationWrapper",
        formId: "scholarshipForm",
        saveButtonId: "btnSave",
        cancelButtonId: "btnCancel",

        fileInputIds: [
            'fileRequestLetter',
            'fileAdmissionLetter',
            'fileJambResult',
            'fileWaecResult',
            'fileMatriculationNumber',
            'fileIndigeneCertificate',
            'fileBirthCertificate',
            'fileValidIdCard'
        ],

        notificationFormContainerId: 'scholarship-form-notification',
        validatableControlSelector: 'input, textarea, select, [data-parsley-require-if], [data-parsley-radio-required]',

    });

    console.log("DOM fully loaded and parsed");
});