export default interface IMgtCenterConfig {
    wrapperSelector: string;
    tabWrapperSelector: string;
    tabSelector: string;
    tabContentSelector: string;
    tableSelector: string;

    activeContentClass: string;

    activeTabClasses: string[];
    inactiveTabClasses: string[];
}