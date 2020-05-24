import {parse} from "../utils/common";
import {formatErrorCode} from "../utils/formatter";

export class Word {
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
        this.version = null;
        this.createdAt = null;
        this.updatedAt = null;
    }

    load = function(object) {
        if (typeof object !== "undefined") {
            console.log(object.word)

            this.id = object.id;
            this.text = object.word;
            this.language = object.language;
            this.wordType = object.wordType;
            this.version = object.version;
            this.createdAt = object.createdAt;
            this.updatedAt = object.updatedAt;
        }

        return this;
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
        return {
            'word' : this.text,
            'wordType' : this.wordType,
            'language' : this.language,
        }
    }
    patch = function () {
        return {
            'id' : this.id,
            'word' : this.text,
            'language' : this.language,
            'wordType' : this.wordType,
        }
    }
}