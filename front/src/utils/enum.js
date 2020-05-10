import i18n from './../i18n'

export const WordTypes =  () => {
    return [
        {value: null, text: i18n.t('form.select')},
        { value: 'adjective', text: i18n.t('word.type.adjective') },
        { value: 'adverb', text: i18n.t('word.type.adverb') },
        { value: 'conjunction', text: i18n.t('word.type.conjunction') },
        { value: 'noun', text: i18n.t('word.type.noun') },
        { value: 'preposition', text: i18n.t('word.type.preposition') },
        { value: 'pronoun', text: i18n.t('word.type.pronoun') },
        { value: 'verb', text: i18n.t('word.type.verb') },
        { value: 'other', text: i18n.t('word.type.other') },
    ]
}

export const Languages =  () => {
    return [
        {value: null, text: i18n.t('form.select')},
        {value: 'br', text: i18n.t('common.language.breton')},
        {value: 'fr', text: i18n.t('common.language.french')},
    ]
}

export const Translation = {
    'br': 'fr',
    'fr': 'br'
};

export const Status = {
    'approved' : 'approved',
    'pending' : 'pending',
    'deleted' : 'deleted'
}