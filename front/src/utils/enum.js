import i18n from './../i18n'
import Constant from "./const";

export const WordTypes =  () => {
    return [
        {value: null, text: i18n.t('form.select')},
        { value: Constant.ADJECTIVE, text: i18n.t('word.type.adjective') },
        { value: Constant.ADVERB, text: i18n.t('word.type.adverb') },
        { value: Constant.CONJUNCTION, text: i18n.t('word.type.conjunction') },
        { value: Constant.NOUN, text: i18n.t('word.type.noun') },
        { value: Constant.PREPOSITION, text: i18n.t('word.type.preposition') },
        { value: Constant.PRONOUN, text: i18n.t('word.type.pronoun') },
        { value: Constant.VERB, text: i18n.t('word.type.verb') },
        { value: Constant.OTHER, text: i18n.t('word.type.other') },
    ]
}

export const Languages =  () => {
    return [
        {value: null, text: i18n.t('form.select')},
        {value: Constant.BR, text: i18n.t('common.language.breton')},
        {value: Constant.FR, text: i18n.t('common.language.french')},
    ]
}

export const Translation = {
    'br': 'fr',
    'fr': 'br'
};

export const Status = () => [
    { value: Constant.ACCEPT, text: i18n.t('translation.status.approved') },
    { value: Constant.PENDING, text: i18n.t('translation.status.pending') },
    { value: Constant.REVIEW, text: i18n.t('translation.status.review') },
    { value: Constant.DELETED, text: i18n.t('translation.status.deleted') },
]
