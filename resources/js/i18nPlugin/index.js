import Vue from "vue";
import VueI18n from "vue-i18n";
import $en from './locales/en';
import {storage} from '../store/index';
import * as rules from 'vee-validate/dist/rules';
import {extend} from "vee-validate";

Vue.use(VueI18n);

const messages = {
    en: $en,
}

Object.keys(rules).forEach(rule => {
    extend(rule, {
        ...rules[rule], // copies rule configuration
        message: messages[rule] // assign message
    });
});

export const i18n = new VueI18n({
    locale: storage.state.lang || 'en',
    fallbackLocale: 'en',
    messages,
    globalInjection: true,
    legacy: false
});

