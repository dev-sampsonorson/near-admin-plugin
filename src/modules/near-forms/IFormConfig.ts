export default interface IFormConfig {
    formWrapperId: string;
    formId: string;
    saveButtonId: string;
    cancelButtonId: string;

    fileNumberSelector?: string;
    fileInputIds?: string[];
    completionNotificationModalSelector?: string;

    notificationFormContainerId: string;
    validatableControlSelector: string;
}