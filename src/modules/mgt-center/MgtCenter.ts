import TeboUtility from "../../TeboUtility";
import IMgtCenterConfig from "./IMgtCenterConfig";



export default class MgtCenter {
    private wrapperEl: HTMLElement;
    private tabWrapperEl: HTMLElement;

    private tabEls?: HTMLElement[];
    private tabContentEls?: HTMLElement[];

    private tblRecordEl: HTMLElement;

    private detailsPopupEl: HTMLElement;
    private btnCloseEl: HTMLElement;

    constructor(private config: IMgtCenterConfig) {
        this.wrapperEl = document.querySelector(this.config.wrapperSelector) as HTMLElement;

        this.tabWrapperEl = document.querySelector(this.config.tabWrapperSelector) as HTMLElement;

        if (this.tabWrapperEl !== null) {
            this.tabEls = Array.from(this.tabWrapperEl?.querySelectorAll(this.config.tabSelector));
            this.tabContentEls = Array.from(this.tabWrapperEl?.querySelectorAll(this.config.tabContentSelector));
        }

        this.tblRecordEl = document.querySelector(this.config.tableSelector) as HTMLElement;

        this.detailsPopupEl = document.getElementById("detailsPopup") as HTMLElement;
        this.btnCloseEl = document.getElementById("btnClose") as HTMLElement;

        this.setup();

        // console.log('hurray');
    }

    setup() {
        this.tabWrapperEl?.addEventListener("click", e => {
            const el = e.target as HTMLElement;

            if (!el.classList.contains('nav-link')) return;

            // get content id
            const contentId = el.getAttribute('data-near-tab-content-id');
            const contentToSelect = this.tabContentEls?.find(foundEl => foundEl.id === contentId);
            const tabToSelect = this.tabEls?.find(foundEl => foundEl.getAttribute('data-near-tab-content-id') === contentId);

            this.tabEls?.forEach((item, index) => {
                if (item.getAttribute('data-near-tab-content-id') === contentId) {
                    this.config.inactiveTabClasses.forEach(className => {
                        item.classList.remove(className);
                    });

                    this.config.activeTabClasses.forEach(className => {
                        item.classList.add(className);
                    });
                } else {
                    this.config.inactiveTabClasses.forEach(className => {
                        item.classList.add(className);
                    });

                    this.config.activeTabClasses.forEach(className => {
                        item.classList.remove(className);
                    });
                }
            });

            this.tabContentEls?.forEach((item, index) => {
                item.classList.remove(this.config.activeContentClass);

                if (item.id === contentId)
                    item.classList.add(this.config.activeContentClass);


            });


            // select content id

            // hide other content ids

            // show selected content id



            // const tabEl: HTMLElement = TeboUtility.getClosest(el, `[${this.config.sectionIndexAttr}]`);
            // const sectionIndex: number = +tabEl.getAttribute(this.config.sectionIndexAttr)!;

            e.stopPropagation();
        }, false);

        this.btnCloseEl?.addEventListener('click', e => {
            e.preventDefault();

            if (!this.detailsPopupEl?.classList.contains('hidden')) {
                this.detailsPopupEl?.classList.add('hidden');
            }

            return false;
        }, false);

        this.tblRecordEl?.addEventListener('click', async (e) => {
            e.preventDefault();

            const el = e.target as HTMLElement;

            if (!el.classList.contains('view-record'))
                return;

            // TODO: show please wait

            const recordId = +el.getAttribute('data-record-id')!;
            const recordType = el.getAttribute('data-record-type')!;
            const recordResult = await this.getRecordInfo(recordId, recordType).catch(this.handleError);

            const retrievedRecordId = +recordResult.id;

            if (retrievedRecordId !== recordId)
                throw new Error('Invalid record');

            if (recordType === 'volunteer') {
                this.setDetailInformation(this.detailsPopupEl, recordResult);
            } else if (recordType === 'scholarship') {
                this.setDetailInformation(this.detailsPopupEl, recordResult);
            } else if (recordType === 'donation') {
                this.setDetailInformation(this.detailsPopupEl, recordResult);
            }

            console.log(this.detailsPopupEl);

            if (this.detailsPopupEl?.classList.contains('hidden')) {
                this.detailsPopupEl?.classList.remove('hidden');
            }

            return false;
        }, false);
    }

    async getRecordInfo(recordId: number, recordType: string) {
        try {
            const url = backend_script_config.ajaxRequestUrl;
            const response = await fetch(url + `?recordId=${recordId}&recordType=${recordType}&action=getRecordInfo&nonce=${backend_script_config.getRecordInfoNonce}`);

            if (response.status !== 200)
                throw new Error("Unable to get record information");

            return (await response.json()).data.result;
        } catch (e) {
            console.log(e);
        }
    }

    setDetailInformation(popupEl, data) {
        let excludes = ['id'];

        console.log('data', data);

        for (let [key, value] of Object.entries(data)) {
            if (excludes.indexOf(key) !== -1)
                continue;

            let el = popupEl?.querySelector(`#txt-${key}`);

            if (typeof (el) === 'undefined' || el === null)
                continue;

            if (typeof (value) === 'undefined' || value === null) {
                value = 'Not Specified';
            }

            if (TeboUtility.isArray(value)) {
                let temp: string = '';
                for (const item of <any>value) {
                    temp += item + ',<br />';
                }

                value = temp.substring(0, temp.lastIndexOf(',<br />'));
            }

            let infoEl = popupEl?.querySelector(`#txt-${key}`) as HTMLElement;

            if (infoEl.nodeName === 'A') {
                infoEl.setAttribute('href', `${value}`);

            } else {
                infoEl.innerHTML = `${value}`;
            }

        }
    }


    handleError(err) {
        console.warn(err);
    }
}