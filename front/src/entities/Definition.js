import {Translation} from "./Translation";
import {parse} from "../utils/common";
import {formatErrorCode} from "../utils/formatter";

export class Definition {
    constructor() {
        this.id = null;
        this._text = null;
        this.textError = null;
        Object.defineProperty(this, 'text', {
            get () {
                return this._text;
            },
            set (value) {
                this._text = value
                if (this.textError != null) {
                    this.textError = null
                }
            }
        });
        this._type = null;
        this.typeError = null;
        Object.defineProperty(this, 'type', {
            get () {
                return this._type;
            },
            set (value) {
                this._type = value
                if (this.typeError != null) {
                    this.typeError = null
                }
            }
        });
        this._langueage = null;
        this.languageError = null;
        Object.defineProperty(this, 'language', {
            get () {
                return this._langueage;
            },
            set (value) {
                this._langueage = value
                if (this.languageError != null) {
                    this.languageError = null
                }
            }
        });
        this.translations = [];
        this.version = null;
        this.status = null;
        this.createdAt = null;
        this.updatedAt = null;
    }

    load = function(object) {
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
    loadErrors = function (errors) {
        let violations = errors.violations;
        let _this = this;
        violations.forEach(function (violation) {
            let parsedPropertyPath = parse(violation.propertyPath);
            let currentProperty = parsedPropertyPath[0]
            switch (currentProperty) {
                case 'text' :
                    _this.textError = formatErrorCode(violation.payload.code);
                    break;
                case 'type' :
                    _this.typeError = formatErrorCode(violation.payload.code);
                    break;
                case 'language' :
                    _this.languageError = formatErrorCode(violation.payload.code);
                    break;
                case 'translations':
                    // eslint-disable-next-line no-case-declarations
                    let translationId = parsedPropertyPath[1];
                    parsedPropertyPath.splice(0,2);
                    _this.translations[translationId].loadError(parsedPropertyPath, violation.payload.code)
                    break;
                default:
                    console.error('unrecognized property : '+ currentProperty);
            }
        })
    }
    post = function () {
        let translations = [];
        this.translations.forEach(function (translation) {
            translations.push(translation.post())
        })
        return {
            'text' : this.text,
            'type' : this.type,
            'language' : this.language,
            'translations' : translations,
        }
    }
    patch = function () {
        let translations = [];
        this.translations.forEach(function (translation) {
            translations.push(translation.patch())
        })
        return {
            'id' : this.id,
            'text' : this.text,
            'language' : this.language,
            'type' : this.type,
            'translations' : translations,
        }
    }
}