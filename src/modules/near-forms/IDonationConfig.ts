export default interface IDonationConfig {
    formWrapperId: string;
    formId: string;
    donateButtonId: string;
    amountElementId: string;

    notificationFormContainerId: string;
    validatableControlSelector: string;

    publicKey: string;
    doneMessageDisplaySelector: string;
    successMessage: string;
    processingMessage: string;
}