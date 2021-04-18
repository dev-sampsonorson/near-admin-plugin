
import $ from 'jquery';
import TeboUtility from '../../TeboUtility';

export default class FormDataExtractor {

    private formEl: JQuery<Element> | null = null;

    constructor() { }

    /**
     * Breaks down given fieldName string to pieces. For ex:
     *
     * If fieldName is "contact[person][name]" result is ["person", "name"].
     * If keepFirstElement is true then result is ["contact", "person", "name"].
     * Result may vary if you pass different expression.
     *
     * @param {string} fieldName that will be splited by expression param.
     * @param {regexp} expression used to break down fieldName to pieces.
     * @param {boolean} keepFirstElement if false/null first extracted name part will be ommited.
     * @return {array} array of strings.
     */
    private extractFieldNames(fieldName, expression?, keepFirstElement?) {

        let searchResult: any[] = [];

        // expression = expression || /([^\]\[]+)/g;
        expression = expression || /([^\]\[]+|\[\]{1})/g;
        keepFirstElement = keepFirstElement || false;

        let elements: any = [];

        while ((searchResult = expression.exec(fieldName))) {
            elements.push(searchResult[0]);
        }

        if (!keepFirstElement && elements.length > 0) elements.shift();


        return elements;
    }

    /**
     * This function converts form fields and values to object stucture that
     * then can be easely stringyfied with JSON.stringify() method.
     * 
     * Form fields shoud be named in [square][brackets] convention.
     * Nesting of fields will be keeped. 
     *
     * @param {object} jQuery object that represents form element.
     * @return {object} plain JS object with properties named after form fields.
     */
    public toObject(formEl: HTMLFormElement): object {
        this.formEl = $(formEl);

        let currentField: any = null;
        let currentProperties: any = null;

        // result of this function
        let data = {};

        // get array of fields that exist in this form
        let fields = this.formEl.serializeArray();
        
        for (let i = 0; i < fields.length; ++i) {
            currentField = fields[i];
            // extract field names
            currentProperties = this.extractFieldNames(currentField.name);

            // add new fields to our data object
            this.attachProperties(data, currentProperties, currentField.value);
        }

        return data;
    }

    /**
     * This function modifies target object by setting chain of nested fields.
     * Fields will have names as passed in properties array. Value param is assigned to 
     * field at the end of chain. For ex:
     *
     * If properties array is ["person", "name"] and value is "abc", target object will be 
     * modified in this way: target.person.name = "abc";
     *
     * If field at the end is already defined in target, function won't overwrite it.
     *
     * @param {object} object that this function will modify.
     * @param {array} properties to be createad in target object.
     * @param {*} value that will be assigned to the field at the end of chain.
     */
    private attachProperties(target, properties, value) {
        let currentProperty: any;
        let currentTarget = target;
        let propertiesNum = properties.length;
        let lastIndex = propertiesNum - 1;

        for (var i = 0; i < propertiesNum; ++i) {
            currentProperty = properties[i];

            if (currentTarget[currentProperty] === undefined) {
                if (i === lastIndex && currentProperty === '[]') {
                    // !TeboUtility.isArray(currentTarget[properties[i - 1]]) ? currentTarget[properties[i - 1]] = [value] : currentTarget[properties[i - 1]].push(value);
                    !TeboUtility.isArray(currentTarget['group']) ? currentTarget['group'] = [value] : currentTarget['group'].push(value);
                } else if (i === lastIndex && currentProperty !== '[]') {
                    currentTarget[currentProperty] = value;
                } else {
                    currentTarget[currentProperty] = {};
                }
            }

            /* if (currentProperty !== '[]') {
                // console.log(currentProperty);
            } */
            currentTarget = currentTarget[currentProperty];
        }
    }
}