export class Example {
    constructor() {
        this.fromLanguage = null;
        this._fromText = null;
        this.fromTextError = null;
        Object.defineProperty(this, 'fromText', {
            get() {
                return this._fromText;
            },
            set(value) {
                this._fromText = value
                if (this.fromTextError != null) {
                    this.fromTextError = null
                }
            }
        });
        this.toLanguage = null;
        this._toText = null;
        this.toTextError = null;
        Object.defineProperty(this, 'toText', {
            get() {
                return this._toText;
            },
            set(value) {
                this._toText = value
                if (this.toTextError != null) {
                    this.toTextError = null
                }
            }
        });
    }
    load = function(object) {
        this.fromLanguage = object.fromLanguage;
        this.fromText = object.fromText;
        this.toLanguage = object.toLanguage;
        this.toText = object.toText;
    }
    loadError = function (path, code) {
        let currentProperty = path[0]
        switch (currentProperty) {
            case 'fromLanguage' :
                break;
            case 'fromText' :
                this.fromTextError = code;
                break;
            case 'toLanguage' :
                break;
            case 'toText' :
                this.toTextError = code;
                break;
            default:
                console.error('unrecognized property : '+ currentProperty);
        }
    }
    post = function () {
        return {
            'fromLanguage' : this.fromLanguage,
            'fromText' : this.fromText,
            'toLanguage' : this.toLanguage,
            'toText' : this.toText,
        }
    }
    patch = function () {
        return {
            'fromLanguage' : this.fromLanguage,
            'fromText' : this.fromText,
            'toLanguage' : this.toLanguage,
            'toText' : this.toText,
        }
    }
}