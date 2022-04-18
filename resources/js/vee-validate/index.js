import {configure} from "vee-validate";
import {i18n} from "../i18nPlugin/index";

configure({
    defaultMessage: (field, values) => {
        // override the field name.
        values._field_ = i18n.t(`fields.${field}`);

        return i18n.t(`validation.${values._rule_}`, values);
    }
});
