import i18n from 'i18next';
import {initReactI18next} from 'react-i18next';
import LanguageDetector from 'i18next-browser-languagedetector';
import {LOCALES} from "@/i18n/constants.js";
import {uk} from "@/i18n/locales/uk/uk.js";
import {en} from "@/i18n/locales/en/en.js";

const resources = {
    [LOCALES.UKR]: {
        translation: uk
    },
    [LOCALES.EN]: {
        translation: en
    }
}

i18n
    .use(LanguageDetector)
    .use(initReactI18next)
    .init({
        resources,
        fallbackLng: LOCALES.UKR,
        debug: true,
        interpolation: {
            escapeValue: false, // React already escapes values
        },
    });

export default i18n;
