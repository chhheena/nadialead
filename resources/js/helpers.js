
import _ from "lodash";
import {useToast} from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import { menus } from "./menus";
import { mappingFields } from "@/LeadFilters/fields"

const $toast = useToast();

export const trans = (string, args) => {
    let value = _.get(window.i18n, string);

    let defaultVal = _.last(_.split(string, "."));
    if (value) {
        _.eachRight(args, (paramVal, paramKey) => {
            value = _.replace(value, `:${paramKey}`, paramVal);
        });
    } else {
        value = defaultVal;
    }
    return value;
};

export const convertJsonToFormData = (data) => {
    const formData = new FormData()
    const entries = Object.entries(data)
    for (const element of entries) {
        const arKey = element[0]
        let arVal = element[1]
        if (typeof arVal === 'boolean') {
            arVal = arVal === true ? 1 : 0
        }
        if (Array.isArray(arVal)) {
            if (arVal[0] instanceof Object) {
                for (let j = 0; j < arVal.length; j++) {
                    if (arVal[j] instanceof Object) {
                        for (const prop in arVal[j]) {
                            if (Object.prototype.hasOwnProperty.call(arVal[j], prop)) {
                                if (!isNaN(Date.parse(arVal[j][prop]))) {
                                    formData.append(
                                        `${arKey}[${j}][${prop}]`,
                                        new Date(arVal[j][prop])
                                    )
                                } else {
                                    formData.append(`${arKey}[${j}][${prop}]`, arVal[j][prop])
                                }
                            }
                        }
                    }
                }
                continue
            } else {
                arVal = JSON.stringify(arVal)
            }
        }

        if (arVal === null) {
            continue
        }
        formData.append(arKey, arVal)
    }
    return formData
};

export const notificationMessage = (type, message) => {
    const toast = $toast[type](message,{
        position: 'top-right',
        duration: 3000,
        dismissible: true
    });
    return toast;
}

export const getMenuBaseOnRole = (role) => {
    return menus[role];
}

export const getFieldsBaseOnRole = (role) => {
    return mappingFields[role]
}