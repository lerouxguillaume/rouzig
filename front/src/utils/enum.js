import i18n from './../i18n'

export const Types =  () => {
    return [
        {value: null, text: i18n.t('form.select')},
        { value: 'verb', text: i18n.t('common.verb') },
        { value: 'noun', text: i18n.t('common.noun') },
    ]
}

export const Languages =  () => {
    return [
        {value: null, text: i18n.t('form.select')},
        {value: 'br', text: i18n.t('common.breton')},
        {value: 'fr', text: i18n.t('common.french')},
    ]
}
