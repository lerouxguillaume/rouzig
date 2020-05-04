import {Example} from "./Example";

export class Translation {
    constructor(language) {
        this._text = null;
        this.textError = null;
        Object.defineProperty(this, 'text', {
            get() {
                return this._text;
            },
            set(value) {
                this._text = value
                if (this.textError != null) {
                    this.textError = null
                }
            }
        });
        this._type = null;
        this.typeError = null;
        Object.defineProperty(this, 'type', {
            get() {
                return this._type;
            },
            set(value) {
                this._type = value
                if (this.typeError != null) {
                    this.typeError = null
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
        this.text = object.text;
        this.language = object.language;
        this.type = object.type;
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
            case 'text' :
                this.textError = code;
                break;
            case 'type' :
                this.typeError = code;
                break;
            case 'language' :
                this.languageError = code;
                break;
            case 'description' :
                this.description = code;
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
            'text' : this.text,
            'type' : this.type,
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
            'text' : this.text,
            'type' : this.type,
            'language' : this.language,
            'description' : this.description,
            'examples': examples
        }
    }
}