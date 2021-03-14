export default interface IFormConfig {
    formWrapperId: string;
    formId: string;
    saveButtonId: string;
    cancelButtonId: string;

    fileInputIds?: string[];

    notificationFormContainerId: string;
    validatableControlSelector: string;
}