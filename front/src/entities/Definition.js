import {Translation} from "./Translation";

export function Definition() {
    this.id = null;
    this.text = null;
    this.language = null;
    this.type = null;
    this.translations = [];
    this.version = null;
    this.status = null;
    this.createdAt = null;
    this.updatedAt = null;
    this.load = function(object) {
        let attributes = object.attributes;
        this.id = attributes._id;
        this.text = attributes.text;
        this.language = attributes.language;
        this.type = attributes.type;
        this.version = attributes.version;
        this.status = attributes.status;
        this.createdAt = attributes.createdAt;
        this.updatedAt = attributes.updatedAt;

        let _this = this;
        attributes.translations.forEach(function (translation) {
            let newTranslation = new Translation();
            newTranslation.load(translation);
            _this.translations.push(newTranslation);
        })
    };
    this.patch = function () {
        return {
            'id' : this.id,
            'text' : this.text,
            'language' : this.language,
            'type' : this.type,
            'translations' : this.translations,
        }
    }
}