import {formatErrorCode} from "../utils/formatter";
import {Languages} from "../utils/enum";

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
        this._language = null;
        this.languageError = null;
        Object.defineProperty(this, 'language', {
            get () {
                return this._language;
            },
            set (value) {
                this._language = value
                if (this.languageError != null) {
                    this.languageError = null
                }
            }
        });
        Object.defineProperty(this, 'languageLabel', {
            get () {
                return Languages().find(element => element.value === this._language).text;
            },
        });
        this.version = null;
        this.createdAt = null;
        this.updatedAt = null;
    }

    load = function(object) {
        if (typeof object !== "undefined" && object !== null) {
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

    loadError = function (path, code) {
        switch (path[0]) {
            case 'word' :
                this.textError = formatErrorCode(code);
                break;
            case 'wordType' :
                this.wordTypeError = formatErrorCode(code);
                break;
            case 'language' :
                this.languageError = formatErrorCode(code);
                break;
            default:
                console.error('unrecognized property : '+ path);
        }

        return this;
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