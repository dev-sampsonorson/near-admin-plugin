import MgtCenter from "./modules/mgt-center/MgtCenter";
import TeboUtility from "./TeboUtility";

window.addEventListener('DOMContentLoaded', (event) => {
    if (!TeboUtility.elementExist('#management-center-wrapper'))
        return;

    const mgtCenter = new MgtCenter({
        wrapperSelector: '#management-center-wrapper',
        tabWrapperSelector: '#popUpMainContent .near-tab',
        tabSelector: '.near-tab__nav .nav-link',
        tabContentSelector: '.near-tab__content-wrapper .near-tab__content',
        tableSelector: '#tblRecords',

        activeContentClass: 'near-tab__content--active',
        activeTabClasses: [
            'border-indigo-500',
            'text-indigo-600'
        ],
        inactiveTabClasses: [
            'border-transparent',
            'text-gray-500',
            'hover:text-gray-700',
            'hover:border-gray-200'
        ]
    });


    console.log("DOM fully loaded and parsed");
});