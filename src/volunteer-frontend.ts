// import $ from 'jquery';
import VolunteerForm from './modules/near-forms/VolunteerForm';
import TeboUtility from './TeboUtility';
import 'bootstrap/js/dist/alert';

window.addEventListener('DOMContentLoaded', (event) => {
    if (!TeboUtility.elementExist('#volunteerApplicationWrapper'))
        return;

    const volunteerForm = new VolunteerForm({
        formWrapperId: "volunteerApplicationWrapper",
        formId: "volunteerForm",
        saveButtonId: "btnSave",
        cancelButtonId: "btnCancel",

        notificationFormContainerId: 'volunteer-form-notification',
        validatableControlSelector: 'input, textarea, select, [data-parsley-require-if], [data-parsley-radio-required]',

    });

    console.log("DOM fully loaded and parsed");
});