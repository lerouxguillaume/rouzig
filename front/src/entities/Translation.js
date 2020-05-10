import {Example} from "./Example";
import {formatErrorCode} from "../utils/formatter";

export class Translation {
    constructor(language) {
        this._word = null;
        this.wordError = null;
        Object.defineProperty(this, 'word', {
            get() {
                return this._word;
            },
            set(value) {
                this._word = value
                if (this.wordError != null) {
                    this.wordError = null
                }
            }
        });
        this._wordType = null;
        this.wordTypeError = null;
        Object.defineProperty(this, 'wordType', {
            get() {
                return this._wordType;
            },
            set(value) {
                this._wordType = value
                if (this.wordTypeError != null) {
                    this.wordTypeError = null
                }
            }
        });
        this._langueage = language;
        this.languageError = null;
        Object.defineProperty(this, 'language', {
            get() {
                return this._langueage;
            },
            set(value) {
                this._langueage = value
                if (this.languageError != null) {
                    this.languageError = null
                }
            }
        });
        this._descriptions = null;
        this.descriptionError = null;
        Object.defineProperty(this, 'description', {
            get() {
                return this._description;
            },
            set(value) {
                this._description = value
                if (this.descriptionError != null) {
                    this.descriptionError = null
                }
            }
        });
        this.examples = [];
    }
    load = function(object) {
        this.word = object.word;
        this.language = object.language;
        this.wordType = object.wordType;
        this.description = object.description;

        let _this = this;
        object.examples.forEach(function (example) {
            let newExample = new Example();
            newExample.load(example);
            _this.examples.push(newExample)
        })
    }
    loadError = function (path, code) {
        let currentProperty = path[0]
        switch (currentProperty) {
            case 'word' :
                this.wordError = formatErrorCode(code);
                break;
            case 'wordType' :
                this.wordTypeError = formatErrorCode(code);
                break;
            case 'language' :
                this.languageError = formatErrorCode(code);
                break;
            case 'description' :
                this.description = formatErrorCode(code);
                break;
            case 'examples':
                // eslint-disable-next-line no-case-declarations
                let exampleId = path[1];
                path.splice(0,2);
                this.examples[exampleId].loadError(path, code)
                break;
            default:
                console.error('unrecognized property : '+ currentProperty);
        }
    }
    post = function () {
        let examples = [];
        this.examples.forEach(function (example) {
            examples.push(example.post())
        })
        return {
            'word' : this.word,
            'wordType' : this.wordType,
            'language' : this.language,
            'description' : this.description,
            'examples': examples
        }
    }
    patch = function () {
        let examples = [];
        this.examples.forEach(function (example) {
            examples.push(example.patch())
        })
        return {
            'word' : this.word,
            'wordType' : this.wordType,
            'language' : this.language,
            'description' : this.description,
            'examples': examples
        }
    }
}