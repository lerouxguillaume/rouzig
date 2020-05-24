import i18n from "../i18n";

const Trans = {
    get currentLanguage () {
        return i18n.locale
    },
    set currentLanguage (lang) {
        i18n.locale = lang
    },
    get supportedLanguages () {
        return ['fr', 'br']
    },

    /**
     * Checks if a lang is supported
     * @param {String} lang
     * @return {boolean}
     */
    isLangSupported (lang) {
        return Trans.supportedLanguages.includes(lang)
    }
}

export { Trans }