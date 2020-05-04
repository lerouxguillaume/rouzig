import i18n from './../i18n'

export const Types =  () => {
    return [
        {value: null, text: i18n.t('form.select')},
        { value: 'verb', text: i18n.t('word.type.verb') },
        { value: 'noun', text: i18n.t('word.type.noun') },
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