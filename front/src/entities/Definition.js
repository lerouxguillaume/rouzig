import {Translation} from "./Translation";
import {parse} from "../utils/common";
import {formatErrorCode} from "../utils/formatter";

export class Definition {
    constructor() {
        this.id = null;
        this._word = null;
        this.wordError = null;
        Object.defineProperty(this, 'word', {
            get () {
                return this._word;
            },
            set (value) {
                this._word = value
                if (this.wordError != null) {
                    this.wordError = null
                }
            }
        });
        this._wordType = null;
        this.wordTypeError = null;
        Object.defineProperty(this, 'wordType', {
            get () {
                return this._wordType;
            },
            set (value) {
                this._wordType = value
                if (this.wordTypeError != null) {
                    this.wordTypeError = null
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
        this.word = attributes.word;
        this.language = attributes.language;
        this.wordType = attributes.wordType;
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
                case 'word' :
                    _this.wordError = formatErrorCode(violation.payload.code);
                    break;
                case 'wordType' :
                    _this.wordTypeError = formatErrorCode(violation.payload.code);
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
            'word' : this.word,
            'wordType' : this.wordType,
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
            'word' : this.word,
            'language' : this.language,
            'wordType' : this.wordType,
            'translations' : translations,
        }
    }
}